<?php

namespace App\Http\Controllers;

use App\Models\Slip;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SlipController extends Controller
{
 public function index(Request $request)
{
    $query = Slip::with('user');

    if ($month = $request->month) {
        $query->whereMonth('period', $month);
    }

    if ($year = $request->year) {
        $query->whereYear('period', $year);
    }

    $slips  = $query->orderByDesc('period')->get();
    $years  = Slip::selectRaw('YEAR(period) as year')->distinct()->pluck('year');
    $users  = User::all();
    $nextId = Slip::count() + 1;
    $mode   = 'index'; // ✅ tambahkan ini

    return view('index.slip_gaji', compact('slips','years','users','nextId', 'mode'));
}



public function create()
{
    $slips  = Slip::with('user')->orderByDesc('period')->get();
    $users  = User::all();
    $nextId = Slip::count() + 1;
    $mode   = 'create'; // ✅ tambahkan ini

    return view('index.slip_gaji', compact('slips','users','nextId', 'mode'));
}





    public function store(Request $request)
    {
         Log::info('Slip@store called', $request->all());
        // Validasi input
        $data = $request->validate([
            'user_id'            => 'required|exists:users,id',
            'period'             => 'required|date_format:Y-m',
            'earnings'           => 'required|array|min:1',
            'earnings.*.name'    => 'required|string',
            'earnings.*.amount'  => 'required|numeric|min:0',
            'deductions'             => 'nullable|array',
            'deductions.*.name'      => 'required_with:deductions|string',
            'deductions.*.amount'    => 'required_with:deductions|numeric|min:0',
        ]);

        // Hitung total earnings dan bonus
        $totalEarnings = collect($data['earnings'])->sum('amount');
        $bonus = $this->calculateBonus($data);
        $totalEarnings += $bonus;

        // Hitung total deductions
        $totalDeductions = collect($data['deductions'] ?? [])->sum('amount');
        $netSalary = $totalEarnings - $totalDeductions;

        // Generate slip_number unik
        $year = now()->format('Y');
        $lastNbr = Slip::whereYear('period', $year)
                       ->max(DB::raw("CAST(SUBSTRING(slip_number, -3) AS UNSIGNED)")) ?? 0;
        $nextNbr = str_pad($lastNbr + 1, 3, '0', STR_PAD_LEFT);
        $slipNumber = "SG-{$year}-{$nextNbr}";

        // Simpan slip
        $slip = Slip::create([
            'slip_number' => $slipNumber,
            'user_id'     => $data['user_id'],
            'period'      => $data['period'] . '-01',
            'net_salary'  => $netSalary,
            'status'      => 'Draft',
        ]);

        // Simpan earnings
        foreach ($data['earnings'] as $e) {
            $slip->earnings()->create([
                'name'   => $e['name'],
                'amount' => $e['amount'],
            ]);
        }

        // Simpan deductions
        foreach ($data['deductions'] ?? [] as $d) {
            $slip->deductions()->create([
                'name'   => $d['name'],
                'amount' => $d['amount'],
            ]);
        }

        return redirect()->route('slips.index')
                         ->with('success', 'Slip gaji berhasil disimpan.');
    }

    protected function calculateBonus(array $data)
    {
        $base = collect($data['earnings'])
                    ->firstWhere('name', 'Gaji Pokok')['amount'] ?? 0;
        return $base > 5000000 ? 500000 : 0;
    }

public function edit(Slip $slip)
{
    $users  = User::all();
    $nextId = Slip::count() + 1;
    $mode   = 'edit'; // ✅ tambahkan ini

    return view('index.slip_gaji', compact('slip','users','nextId', 'mode'));
}




    public function update(Request $request, Slip $slip)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'period'  => 'required|date',
        ]);

        $slip->update([
            'user_id' => $data['user_id'],
            'period'  => $data['period'],
        ]);

        // update earnings & deductions jika perlu...

        return redirect()->route('slips.index')
                         ->with('success', 'Slip gaji berhasil diperbarui.');
    }

    public function destroy(Slip $slip)
    {
        $slip->delete();
        return redirect()->route('slips.index')
                         ->with('success', 'Slip gaji berhasil dihapus.');
    }
}