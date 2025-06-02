<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\News;
use App\Models\User;
use App\Models\Slip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        $newsItems = News::orderBy('created_at', 'desc')->get();

        // Cek apakah ada slip gaji yang belum dibaca untuk pengguna saat ini
        $hasUnreadSlip = false;
        if (in_array($role, ['Operator', 'Admin', 'Leader'])) {
            $currentPeriod = Carbon::now()->format('Y-m') . '-01';
            $hasUnreadSlip = Slip::where('user_id', $user->id)
                ->where('period', $currentPeriod)
                ->where('is_read', false)
                ->exists();
        }

        return view('index.dashboard', compact('user', 'role', 'newsItems', 'hasUnreadSlip'));
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
            'phone' => 'required|string|max:20',
            'bio' => 'required|string',
            'alamat' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:81920',
        ];

        $validated = $request->validate($rules);

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
        ], [
            'password.min' => 'Password harus minimal 4 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::findOrFail($request->id);
        $user->password = Hash::make($request->password);
        $user->save();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Password berhasil direset.'
            ], 200);
        }

        return redirect()->route('reset.form', ['success' => 'Password berhasil direset.']);
    }
}