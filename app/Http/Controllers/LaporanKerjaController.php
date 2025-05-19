<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\LaporanKerja;

class LaporanKerjaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;

        $laporanKerja = LaporanKerja::all();

        return view('index.laporan_kerja', compact('laporanKerja', 'role'));
    }
}
