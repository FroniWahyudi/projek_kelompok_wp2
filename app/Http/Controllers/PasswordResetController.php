<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordResetRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function showRequestForm()
    {
        return view('index.pengajuan_reset');
    }

    public function storeRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'keterangan' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        PasswordResetRequest::create([
            'user_id' => $user->id,
            'keterangan' => $request->keterangan,
            'status' => 'pending',
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        return redirect()->back()->with('success', 'Pengajuan reset password berhasil dikirim');
    }

    public function showResetForm()
    {
        $requests = PasswordResetRequest::with('user')
            ->where('status', 'pending')
            ->where('expires_at', '>', Carbon::now())
            ->get();

        return view('index.reset_pw', compact('requests'));
    }

    public function resetPassword($id, Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();

        PasswordResetRequest::where('user_id', $id)->update(['status' => 'completed']);

        return redirect()->back()->with('success', 'Password berhasil direset');
    }

    public function resetPasswordManual(Request $request)
    {   
        $request->validate([
            'old_password' => 'required',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'old_password.required' => 'Password lama wajib diisi.',
        ]);
        $user = User::findOrFail($request->id);
        
        if ($request->filled('email')) {
            $user->email = $request->email;        
        }
        if (!$request->filled('password')) {
            $user->save();
            return redirect()->route('profil.edit', $user->id)->with('success', 'Email berhasil diperbarui.');
        }

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->route('profil.edit', $user->id)->with('error', 'Password lama tidak sesuai.');
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('profil.edit', $user->id)->with('success', 'Password berhasil diperbarui.');
    }

  public function checkRequests()
{
    $exists = PasswordResetRequest::where('status', 'pending')->exists();
    return response()->json(['exists' => $exists]);
}
}