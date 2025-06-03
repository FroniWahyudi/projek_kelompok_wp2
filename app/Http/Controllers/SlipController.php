<?php

namespace App\Http\Controllers;

use App\Models\Slip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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
        
        // Mark as read when operator visits slip page
        $this->markUserSlipsAsRead($user->id); // Changed to new method
    }

    if ($month = $request->month) {
        $query->whereMonth('period', $month);
    }

    if ($year = $request->year) {
        $query->whereYear('period', $year);
    }

    // Ganti get() dengan paginate() dan urutkan berdasarkan id secara langsung di query
    $slips = $query->orderByDesc('period')->orderByDesc('id')->paginate(10); // 10 item per halaman, sesuaikan jika perlu

    $years = Slip::selectRaw('YEAR(period) as year')
        ->distinct()
        ->orderByDesc('year')
        ->pluck('year');
    $users = User::all(['id', 'name', 'id_karyawan']);
    $nextId = Slip::count() + 1;
    $mode = 'index';

    // Check for latest period notification (after marking as read)
    $hasLatestPeriodSlip = false;
    if ($user->role == 'Operator') {
        $hasLatestPeriodSlip = $this->checkLatestPeriodSlip($request)->original['has_unread_slip'];
    }

    return view('index.slip_gaji', compact('slips', 'years', 'users', 'nextId', 'mode', 'hasLatestPeriodSlip'));
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
            'deductions.*.amount.required_with' => 'Jumlah potongan harus diisi.',
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
            'is_read'     => false,
            'read_at'     => null,
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

        // Format period for edit view
        if ($slip->period) {
            try {
                $slip->period = \Carbon\Carbon::parse($slip->period)->format('Y-m');
            } catch (\Exception $e) {
                $slip->period = '';
            }
        }

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
            'deductions.*.amount.required_with' => 'Jumlah potongan harus diisi.',
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
            'is_read'    => false,
            'read_at'    => null,
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

        // Mark as read when user views the slip detail
        $this->markSpecificSlipAsRead($slip->id);

        return view('index.slip_detail', compact('slip'));
    }

    public function downloadPdf($id)
    {
        $slip = Slip::findOrFail($id);
        $slip->load(['user' => function ($query) {
            $query->select('id', 'name', 'id_karyawan', 'department', 'photo_url');
        }, 'earnings', 'deductions']);

        // Mark as read when user downloads the slip
        $this->markSpecificSlipAsRead($slip->id);

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

    /**
     * Check if user has unread slip for current month/year period
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkLatestPeriodSlip(Request $request)
    {
        $userId = $request->input('user_id') ?: Auth::id();
        $currentPeriod = Carbon::now()->format('Y-m') . '-01';

        $slip = Slip::where('user_id', $userId)
            ->where('period', $currentPeriod)
            ->where('is_read', false)
            ->first();

        return response()->json([
            'has_unread_slip' => $slip ? true : false,
            'period' => Carbon::now()->format('Y-m'),
            'user_id' => $userId
        ]);
    }

    /**
     * Mark slip as read for specific user and current period
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request)
    {
        $userId = $request->input('user_id') ?: Auth::id();
        $currentPeriod = Carbon::now()->format('Y-m') . '-01';

        $updated = Slip::where('user_id', $userId)
            ->where('period', $currentPeriod)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => Carbon::now()
            ]);

        return response()->json([
            'success' => $updated > 0,
            'message' => $updated > 0 ? 'Slip gaji periode ini berhasil ditandai sebagai dibaca.' : 'Tidak ada slip gaji yang belum dibaca untuk periode ini.',
            'timestamp' => Carbon::now()
        ]);
    }

    /**
     * Mark all slips as read for a specific user and current period
     *
     * @param int $userId
     * @return bool
     */
    protected function markUserSlipsAsRead($userId)
    {
        $currentPeriod = Carbon::now()->format('Y-m') . '-01';

        $updated = Slip::where('user_id', $userId)
            ->where('period', $currentPeriod)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => Carbon::now()
            ]);

        return $updated > 0;
    }

    /**
     * Mark specific slip as read
     *
     * @param int $slipId
     * @return bool
     */
    public function markSpecificSlipAsRead($slipId)
    {
        $slip = Slip::find($slipId);
        
        if (!$slip || $slip->is_read) {
            return false;
        }

        // Only allow user to mark their own slip as read (for operators)
        if (Auth::user()->role == 'Operator' && $slip->user_id != Auth::id()) {
            return false;
        }

        $slip->update([
            'is_read' => true,
            'read_at' => Carbon::now()
        ]);

        return true;
    }

    /**
     * Get notification status for multiple users
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotificationStatus(Request $request)
    {
        $request->validate([
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $userIds = $request->input('user_ids', [Auth::id()]);
        $currentPeriod = Carbon::now()->format('Y-m') . '-01';

        $usersWithUnreadSlips = Slip::whereIn('user_id', $userIds)
            ->where('period', $currentPeriod)
            ->where('is_read', false)
            ->pluck('user_id')
            ->toArray();

        $results = [];
        foreach ($userIds as $userId) {
            $results[$userId] = in_array($userId, $usersWithUnreadSlips);
        }

        return response()->json([
            'notifications' => $results,
            'period' => Carbon::now()->format('Y-m'),
            'current_period_full' => $currentPeriod
        ]);
    }

    /**
     * Get notification count for dashboard
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotificationCount()
    {
        $user = Auth::user();
        $currentPeriod = Carbon::now()->format('Y-m') . '-01';

        if ($user->role == 'Operator') {
            $count = Slip::where('user_id', $user->id)
                ->where('period', $currentPeriod)
                ->where('is_read', false)
                ->count();
        } else {
            $count = Slip::where('period', $currentPeriod)
                ->where('is_read', false)
                ->count();
        }

        return response()->json([
            'notification_count' => $count,
            'period' => Carbon::now()->format('Y-m'),
            'user_role' => $user->role
        ]);
    }

    /**
     * Get all unread slips for current user or all users (based on role)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnreadSlips()
    {
        $user = Auth::user();
        $currentPeriod = Carbon::now()->format('Y-m') . '-01';

        $query = Slip::with(['user' => function ($q) {
            $q->select('id', 'name', 'id_karyawan', 'department');
        }])
        ->where('period', $currentPeriod)
        ->where('is_read', false);

        if ($user->role == 'Operator') {
            $query->where('user_id', $user->id);
        }

        $unreadSlips = $query->get();

        return response()->json([
            'unread_slips' => $unreadSlips,
            'count' => $unreadSlips->count(),
            'period' => Carbon::now()->format('Y-m')
        ]);
    }
}