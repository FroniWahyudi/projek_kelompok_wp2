<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\SisaCuti;
use App\Models\User;

use Illuminate\Http\Request;

class HrDashboardController extends Controller
{
    public function hr_index() {
        $users=User::whereIn('role', ['HR', 'Leader'])->get();
        return view('index.hr_dashboard', compact('users'));
    }

    public function manajemen_index(){
        $managers=User::where('role', '=', 'Manajer')->get();
        return view('index.manajemen', compact('managers'));
    }

    public function karyawan_index(){
        $tahun = Carbon::now()->year;
        $user = Auth::user();
        $role = $user->role;
        $karyawan = User::where('role', 'Karyawan')
            ->orderBy('name')
            ->get();

        return view('index.karyawan', compact('karyawan', 'tahun','role'));
    }
    
    public function updateSisaCuti(Request $request)
    {
        $tahun = Carbon::now()->year;

        foreach($request->sisa_cuti as $userId => $sisaCuti) {
            SisaCuti::updateOrCreate(
                ['user_id' => $userId, 'tahun' => $tahun],
                ['total_cuti' => $sisaCuti, 'cuti_terpakai' => 0]
            );
        }

        return redirect()->back()->with('success', 'Sisa cuti berhasil disimpan.');
    }
    /*public function update_sisa_cuti(Request $request, $id)
    {
        $sisaCuti = SisaCuti::findOrFail($id);
        $sisaCuti->cuti_sisa = $request->input('cuti_sisa');
        $sisaCuti->save();

        return redirect()->back()->with('success', 'Sisa cuti berhasil diperbarui.');
    }*/
}
