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

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'role' => 'required|string|max:100',
            'bio' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'min:4|confirmed';
        }

        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            $validated['photo_url'] = '/storage/' . $path;
        }

        $user->update($validated);

        return redirect()->route('profil.edit', $user->id)->with('success', 'Profil berhasil diperbarui.');
    }

    public function showResetForm()
    {
        return view('index.reset_pw');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'password' => 'required|min:4|confirmed',
        ]);

        $user = User::findOrFail($request->id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('reset.form')->with('success', 'Password berhasil direset.');
    }
    
}
