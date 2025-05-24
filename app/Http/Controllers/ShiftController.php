<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        // Ambil semua shift beserta data user terkait
        $shifts = Shift::with('user')->orderBy('date')->get();
        $users = User::all(); // untuk dropdown pilihan user (karyawan)

        return view('index.shift_karyawan', compact('shifts', 'users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date'    => 'required|date',
            'type'    => 'required|in:Pagi,Sore,Overtime',
        ]);

        Shift::create($data);

        return redirect()->route('shifts.index')
                         ->with('success', 'Jadwal shift berhasil ditambahkan.');
    }

    public function update(Request $request, Shift $shift)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date'    => 'required|date',
            'type'    => 'required|in:Pagi,Sore,Overtime',
        ]);

        $shift->update($data);

        return redirect()->route('shifts.index')
                         ->with('success', 'Jadwal shift berhasil diubah.');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();

        return redirect()->route('shifts.index')
                         ->with('success', 'Jadwal shift berhasil dihapus.');
    }
}
