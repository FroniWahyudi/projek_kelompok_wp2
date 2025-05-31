<?php

namespace App\Http\Controllers;

use App\Models\Slip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;

class SlipController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Slip::with(['user' => function ($query) {
            $query->select('id', 'name', 'id_karyawan', 'department', 'photo_url');
        }]);

        if ($user->role == 'Operator') {
            $query->where('user_id', $user->id);
        }

        if ($month = $request->month) {
            $query->whereMonth('period', $month);
        }

        if ($year = $request->year) {
            $query->whereYear('period', $year);
        }

        $slips = $query->orderByDesc('period')->get();
        $years = Slip::selectRaw('YEAR(period) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');
        $users = User::all(['id', 'name', 'id_karyawan']);
        $nextId = Slip::count() + 1;
        $mode = 'index';

        return view('index.slip_gaji', compact('slips', 'years', 'users', 'nextId', 'mode'));
    }

    public function create()
    {
        $years = Slip::selectRaw('YEAR(period) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');
        $slips = Slip::with(['user' => function ($query) {
            $query->select('id', 'name', 'id_karyawan', 'department', 'photo_url');
        }])->orderByDesc('period')->get();
        $users = User::where('role', '!=', 'Manajer')
            ->select('id', 'name', 'id_karyawan', 'department', 'photo_url')
            ->get();
        $departments = User::select('department')
            ->distinct()
            ->pluck('department');
        $nextId = Slip::count() + 1;
        $mode = 'create';

        return view('index.slip_create', compact('slips', 'years', 'users', 'departments', 'nextId', 'mode'));
    }

    public function store(Request $request)
    {
        Log::info('Slip@store called', $request->all());

        $data = $request->validate([
            'user_id'             => 'required|exists:users,id',
            'period'              => 'required|date_format:Y-m',
            'earnings'            => 'required|array|min:1',
            'earnings.*.name'     => 'required|string',
            'earnings.*.amount'   => 'required|numeric|min:0',
            'deductions'          => 'nullable|array',
            'deductions.*.name'   => 'required_with:deductions|string',
            'deductions.*.amount' => 'required_with:deductions|numeric|min:0',
        ], [
            'user_id.required'                => 'Pengguna harus dipilih.',
            'user_id.exists'                  => 'Pengguna tidak ditemukan.',
            'period.required'                 => 'Periode harus diisi.',
            'period.date_format'              => 'Format periode harus Y-m (contoh: 2025-01).',
            'earnings.required'               => 'Pendapatan harus diisi.',
            'earnings.min'                    => 'Minimal satu pendapatan harus diisi.',
            'earnings.*.name.required'        => 'Nama pendapatan harus diisi.',
            'earnings.*.amount.required'      => 'Jumlah pendapatan harus diisi.',
            'earnings.*.amount.numeric'       => 'Jumlah pendapatan harus berupa angka.',
            'earnings.*.amount.min'           => 'Jumlah pendapatan tidak boleh negatif.',
            'deductions.*.name.required_with' => 'Nama potongan harus diisi.',
            'deductions.*.amount.required_with'=> 'Jumlah potongan harus diisi.',
            'deductions.*.amount.numeric'     => 'Jumlah potongan harus berupa angka.',
            'deductions.*.amount.min'         => 'Jumlah potongan tidak boleh negatif.',
        ]);

        $existingSlip = Slip::where('user_id', $data['user_id'])
            ->where('period', $data['period'] . '-01')
            ->first();

        if ($existingSlip) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Slip gaji untuk pengguna dan periode ini sudah ada.');
        }

        $totalEarnings = collect($data['earnings'])->sum('amount');
        $totalDeductions = collect($data['deductions'] ?? [])->sum('amount');
        $netSalary = $totalEarnings - $totalDeductions;

        $year = now()->format('Y');
        $lastNbr = Slip::whereYear('period', $year)
            ->max(DB::raw("CAST(SUBSTRING(slip_number, -3) AS UNSIGNED)")) ?? 0;
        $nextNbr = str_pad($lastNbr + 1, 3, '0', STR_PAD_LEFT);
        $slipNumber = "SG-{$year}-{$nextNbr}";

        $slip = Slip::create([
            'slip_number' => $slipNumber,
            'user_id'     => $data['user_id'],
            'period'      => $data['period'] . '-01',
            'net_salary'  => $netSalary,
            'status'      => 'Draft',
        ]);

        foreach ($data['earnings'] as $e) {
            $slip->earnings()->create([
                'name'   => $e['name'],
                'amount' => $e['amount'],
            ]);
        }
        foreach ($data['deductions'] ?? [] as $d) {
            $slip->deductions()->create([
                'name'   => $d['name'],
                'amount' => $d['amount'],
            ]);
        }

        return redirect()->route('slips.index')
            ->with('success', 'Slip gaji berhasil disimpan.');
    }

    public function edit(Slip $slip)
    {
        $slip->load('earnings', 'deductions');
        $years = Slip::selectRaw('YEAR(period) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');
        $users = User::all(['id', 'name', 'id_karyawan']);
        $nextId = Slip::count() + 1;
        $mode = 'edit';

        return view('index.slip_edit', compact('slip', 'years', 'users', 'nextId', 'mode'));
    }

    public function update(Request $request, Slip $slip)
    {
        $data = $request->validate([
            'user_id'             => 'required|exists:users,id',
            'period'              => 'required|date_format:Y-m',
            'earnings'            => 'required|array|min:1',
            'earnings.*.name'     => 'required|string',
            'earnings.*.amount'   => 'required|numeric|min:0',
            'deductions'          => 'nullable|array',
            'deductions.*.name'   => 'required_with:deductions|string',
            'deductions.*.amount' => 'required_with:deductions|numeric|min:0',
        ], [
            'user_id.required'                => 'Pengguna harus dipilih.',
            'user_id.exists'                  => 'Pengguna tidak ditemukan.',
            'period.required'                 => 'Periode harus diisi.',
            'period.date_format'              => 'Format periode harus Y-m (contoh: 2025-01).',
            'earnings.required'               => 'Pendapatan harus diisi.',
            'earnings.min'                    => 'Minimal satu pendapatan harus diisi.',
            'earnings.*.name.required'        => 'Nama pendapatan harus diisi.',
            'earnings.*.amount.required'      => 'Jumlah pendapatan harus diisi.',
            'earnings.*.amount.numeric'       => 'Jumlah pendapatan harus berupa angka.',
            'earnings.*.amount.min'           => 'Jumlah pendapatan tidak boleh negatif.',
            'deductions.*.name.required_with' => 'Nama potongan harus diisi.',
            'deductions.*.amount.required_with'=> 'Jumlah potongan harus diisi.',
            'deductions.*.amount.numeric'     => 'Jumlah potongan harus berupa angka.',
            'deductions.*.amount.min'         => 'Jumlah potongan tidak boleh negatif.',
        ]);

        $existingSlip = Slip::where('user_id', $data['user_id'])
            ->where('period', $data['period'] . '-01')
            ->where('id', '!=', $slip->id)
            ->first();

        if ($existingSlip) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Slip gaji untuk pengguna dan periode ini sudah ada.');
        }

        $totalEarnings = collect($data['earnings'])->sum('amount');
        $totalDeductions = collect($data['deductions'] ?? [])->sum('amount');
        $netSalary = $totalEarnings - $totalDeductions;

        $slip->update([
            'user_id'    => $data['user_id'],
            'period'     => $data['period'] . '-01',
            'net_salary' => $netSalary,
        ]);

        $slip->earnings()->delete();
        $slip->deductions()->delete();

        foreach ($data['earnings'] as $e) {
            $slip->earnings()->create([
                'name'   => $e['name'],
                'amount' => $e['amount'],
            ]);
        }
        foreach ($data['deductions'] ?? [] as $d) {
            $slip->deductions()->create([
                'name'   => $d['name'],
                'amount' => $d['amount'],
            ]);
        }

        return redirect()->route('slips.index')
            ->with('success', 'Slip gaji berhasil diperbarui.');
    }

    public function destroy(Slip $slip)
    {
        $slip->delete();
        return redirect()->route('slips.index')
            ->with('success', 'Slip gaji berhasil dihapus.');
    }

    public function show(Slip $slip)
    {
        $slip->load(['user' => function ($query) {
            $query->select('id', 'name', 'id_karyawan', 'department', 'photo_url');
        }, 'earnings', 'deductions']);
        return view('index.slip_detail', compact('slip'));
    }

    public function downloadPdf($id)
    {
        $slip = Slip::findOrFail($id);
        $slip->load(['user' => function ($query) {
            $query->select('id', 'name', 'id_karyawan', 'department', 'photo_url');
        }, 'earnings', 'deductions']);

        $options = [
            'isHtml5ParserEnabled'    => true,
            'isPhpEnabled'            => true,
            'isRemoteEnabled'         => true,
            'defaultPaperSize'        => 'a4',
            'defaultPaperOrientation' => 'portrait',
        ];

        $pdf = Pdf::setOptions($options)
            ->loadView('index.slip_pdf', compact('slip'));

        return $pdf->download('slip_gaji_' . $slip->id . '.pdf');
    }

    public function checkSlip(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'period'  => 'required|date_format:Y-m',
        ]);

        $userId = $request->input('user_id');
        $period = $request->input('period') . '-01';

        $slip = Slip::where('user_id', $userId)
            ->where('period', $period)
            ->first();

        $users = User::all(['id', 'name', 'id_karyawan']);

        if ($slip) {
            return view('index.cek_slip', [
                'message' => 'Slip sudah dibuat.',
                'users'   => $users,
            ]);
        } else {
            return view('index.cek_slip', [
                'message' => 'Slip belum dibuat.',
                'users'   => $users,
            ]);
        }
    }

    public function showCheckSlipForm()
    {
        $users = User::all(['id', 'name', 'id_karyawan']);
        return view('index.cek_slip', compact('users'));
    }

    public function checkSlipAjax(Request $request)
    {
        $request->validate([
            'user_ids'   => 'required|array',
            'user_ids.*' => 'required|exists:users,id',
            'period'     => 'required|date_format:Y-m',
        ]);

        $userIds = $request->input('user_ids');
        $period = $request->input('period') . '-01';

        $slips = Slip::whereIn('user_id', $userIds)
            ->where('period', $period)
            ->pluck('user_id')
            ->toArray();

        $results = [];
        foreach ($userIds as $userId) {
            $results[$userId] = in_array($userId, $slips);
        }

        return response()->json($results);
    }
}