<?php

namespace App\Http\Controllers;
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
}
