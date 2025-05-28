<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordResetRequest;
use App\Models\User;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    public function showRequestForm()
    {
        return view('index.pengajuan_reset');
    }

    public function storeRequest(Request $request)
    {
        // Logika untuk menyimpan pengajuan reset password
        // Contoh:
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'keterangan' => 'required|string',
        ]);

        PasswordResetRequest::create([
            'user_id' => $request->user_id,
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
            'id' => 'required|exists:users,id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($request->id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil direset');
    }
}