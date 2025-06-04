<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ShiftController extends Controller
{
    public function index()
    {
        // Ambil semua shift beserta data user terkait, termasuk photo_url
        $shifts = Shift::with(['user' => function ($query) {
            $query->select('id', 'name', 'photo_url','department'); // Pastikan photo_url diambil
        }])->orderBy('date')->get();
        $users = User::select('id', 'name', 'photo_url')->get(); // untuk dropdown pilihan user (karyawan)

        $shifts = $shifts->sortByDesc(function($shift) {
            return $shift->user_id === auth()->id() ? 1 : 0;
        })->values();

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
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date'    => 'required|date',
            'type'    => 'required|in:Pagi,Sore,Overtime',
        ]);

        $weekYear = Carbon::parse($request->date)->year . '-' . Carbon::parse($request->date)->isoWeek;

        $existing = Shift::where('user_id', $request->user_id)
            ->where('week_year', $weekYear)
            ->where('id', '!=', $shift->id)
            ->exists();

        if ($existing) {
            return back()->with('error', 'User ini sudah punya shift minggu ini!');
        }

        $shift->update([
            'user_id'   => $request->user_id,
            'date'      => $request->date,
            'type'      => $request->type,
            'week_year' => $weekYear,
        ]);

        return redirect()->route('shifts.index')->with('success', 'Shift berhasil diperbarui!');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();

        return redirect()->route('shifts.index')
                         ->with('success', 'Jadwal shift berhasil dihapus.');
    }
}