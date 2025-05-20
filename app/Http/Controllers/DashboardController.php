<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\News;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        $newsItems = News::all();

        return view('index.dashboard', compact('user', 'role', 'newsItems'));
    }

    public function profil()
    {
        $user = Auth::user();

        return view('index.dashboard_profil', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() !== $user->id) {
            abort(403);
        }

        return view('index.edit_profil', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() !== $user->id) {
            abort(403);
        }

        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'password' => 'nullable|min:4|confirmed',
            'role' => 'required|string|max:100',
            'bio' => 'required|string',
            'photo_url' => 'nullable|string|max:255'
        ]);
        
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            $validated['photo_url'] = '/storage/' . $path;
        }

        $user->fill($validated);
        $user->save();

        return redirect()->route('profil.edit', $user->id)->with('success', 'Profil berhasil diperbarui.');
    }

}
