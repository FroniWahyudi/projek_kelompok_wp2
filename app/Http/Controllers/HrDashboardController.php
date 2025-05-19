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
        $users=User::whereIn('role', ['Admin'])->get();
        return view('index.admin', compact('users'));
    }
    public function leader_index() {
        $users=User::whereIn('role', ['Leader'])->get();
        return view('index.leader', compact('users'));
    }

    public function manajemen_index(){
        $managers=User::where('role', '=', 'Manajer')->first();
        return view('index.manajemen', compact('managers'));
    }

  public function karyawan_index(Request $request)
{
    $tahun       = Carbon::now()->year;
    $user        = Auth::user();
    $sisa_cuti   = SisaCuti::pluck('cuti_sisa', 'user_id');
    $role        = $user->role;

    $search      = $request->input('search');

    $operators   = User::where('role', 'Operator')
                       ->when($search, function ($query, $search) {
                           $query->where('name', 'like', '%' . $search . '%');
                       })
                       ->orderBy('name')
                       ->get();

    // Jika AJAX, kembalikan partial list saja
    if ($request->ajax()) {
        return view('index.partials.operator_list', [
            'Operator'  => $operators,
        ]);
    }

    // Tampilan full saat pertama kali load
    return view('index.operator', [
        'Operator'  => $operators,
        'sisa_cuti' => $sisa_cuti,
        'tahun'     => $tahun,
        'role'      => $role,
    ]);
}


    
    public function updateSisaCuti(Request $request)
    {
        $tahun = Carbon::now()->year;

        foreach($request->sisa_cuti as $userId => $sisaCuti) {
            $totalCuti = SisaCuti::where('user_id', $userId)->value('total_cuti');
            SisaCuti::updateOrCreate(
                ['user_id' => $userId, 'tahun' => $tahun],
                ['cuti_sisa' => $sisaCuti, 'cuti_terpakai' => $totalCuti-$sisaCuti]
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
