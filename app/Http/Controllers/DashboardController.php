<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\News;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        $newsItems = News::all();

        return view('index.dashboard', compact('user', 'role', 'newsItems'));
    }

}
