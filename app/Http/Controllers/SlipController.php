<?php

namespace App\Http\Controllers;

use App\Models\Slip;
use App\Models\User;              // ganti Employee → User
use Illuminate\Http\Request;

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
    $years  = Slip::selectRaw('YEAR(period) as year')
                  ->distinct()
                  ->pluck('year');
    $users  = User::all();           // ⚠️ tambahkan ini
    $nextId = Slip::count() + 1;     // ⚠️ sudah ada sebelumnya

    return view('index.slip_gaji', compact('slips','years','users','nextId'));
}



    public function create()
{
    $slips  = Slip::with('user')->orderByDesc('period')->get();  // ⬅️ tambahkan
    $users  = User::all();
    $years  = [];
    $nextId = Slip::count() + 1;

    return view('index.slip_gaji', compact('slips','users','years','nextId'));
}


    public function store(Request $request)
{
    // 1. Validasi semua field
    $data = $request->validate([
        'id'        => 'required|string|unique:slips,id',
        'user_id'   => 'required|exists:users,id',
        'period'    => 'required|date_format:Y-m',
        'earnings'            => 'required|array|min:1',
        'earnings.*.name'     => 'required|string',
        'earnings.*.amount'   => 'required|numeric|min:0',
        'deductions'            => 'nullable|array',
        'deductions.*.name'     => 'required_with:deductions|string',
        'deductions.*.amount'   => 'required_with:deductions|numeric|min:0',
    ]);

    // 2. Hitung total pendapatan & potongan
    $totalEarnings   = collect($data['earnings'])->sum('amount');
    $totalDeductions = collect($data['deductions'] ?? [])->sum('amount');
    $netSalary       = $totalEarnings - $totalDeductions;

    // 3. Simpan slip utama
    $slip = Slip::create([
        'id'         => $data['id'],
        'user_id'    => $data['user_id'],
        'period'     => $data['period'] . '-01', // simpan sebagai YYYY-MM-01
        'net_salary' => $netSalary,
        'status'     => 'draft', // atau default lain
    ]);

    // 4. Simpan detail earnings
    foreach ($data['earnings'] as $e) {
        $slip->earnings()->create([
            'name'   => $e['name'],
            'amount' => $e['amount'],
        ]);
    }

    // 5. Simpan detail deductions (jika ada)
    foreach ($data['deductions'] ?? [] as $d) {
        $slip->deductions()->create([
            'name'   => $d['name'],
            'amount' => $d['amount'],
        ]);
    }

    // 6. Redirect dengan pesan sukses
    return redirect()->route('slips.index')
                     ->with('success', 'Slip gaji berhasil disimpan.');
}

public function edit(Slip $slip)
{
    $slips  = Slip::with('user')->orderByDesc('period')->get();  // ⬅️ tambahkan
    $users  = User::all();
    $years  = Slip::selectRaw('YEAR(period) as year')->distinct()->pluck('year');
    $nextId = Slip::count() + 1;

    return view('index.slip_gaji', compact('slips','slip','users','years','nextId'));
}




    public function update(Request $request, Slip $slip)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'period'  => 'required|date',
        ]);

        $slip->update($data);

        // update earnings & deductions...

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
