<?php

namespace App\Http\Controllers;

use App\Models\CutiRequest;
use App\Models\SisaCuti;
use App\Models\CutiLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CutiController extends Controller
{
    // Tampilkan daftar pengajuan
    public function index()
    {
        $user = auth()->user();

        $query = CutiRequest::with('user')
            ->orderByDesc('tanggal_pengajuan');

        if ($user->role === 'Manajer') {
            // HR lihat semua, diurutkan status Menunggu dahulu
            $query->orderByRaw("FIELD(status,'Menunggu','Disetujui','Ditolak')");
        } else {
            // User biasa hanya lihat miliknya
            $query->where('user_id', $user->id);
        }

        $cutiRequests = $query->get();

        return view('index.cuti', compact('cutiRequests'));
    }

    // Proses penyimpanan pengajuan baru
    public function store(Request $request)
    {
        $request->validate([
            'tgl_mulai'   => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'alasan'      => 'required|string',
        ]);

        $user    = auth()->user();
        $start   = Carbon::parse($request->tgl_mulai);
        $end     = Carbon::parse($request->tgl_selesai);
        $lama    = $start->diffInDays($end) + 1;
        $tahun   = $start->year;

        // Ambil atau buat record sisa_cuti
        $sisa = SisaCuti::firstOrCreate(
            ['user_id' => $user->id, 'tahun' => $tahun],
            ['cuti_sisa' => 0, 'cuti_terpakai' => 0]
        );

        if (($sisa->cuti_sisa - $sisa->cuti_terpakai) < $lama) {
            return back()->with('error', "Sisa cuti Anda hanya ".
                ($sisa->cuti_sisa - $sisa->cuti_terpakai)." hari, permintaan $lama hari.");
        }

        DB::transaction(function () use ($user, $request, $lama) {
            // Insert pengajuan
            $cuti = CutiRequest::create([
                'user_id'           => $user->id,
                'tanggal_pengajuan' => now()->toDateString(),
                'tanggal_mulai'     => $request->tgl_mulai,
                'tanggal_selesai'   => $request->tgl_selesai,
                'lama_cuti'         => $lama,
                'alasan'            => $request->alasan,
                'status'            => 'Menunggu',
            ]);

            // Log pembuatan
            CutiLogs::create([
                'cuti_request_id' => $cuti->id,
                'aksi'            => 'Dibuat',
                'oleh_user_id'    => $user->id,
                'keterangan'      => 'Pengajuan dibuat',
            ]);

            // Update cuti_terpakai
            SisaCuti::where('user_id', $user->id)
                ->where('tahun', Carbon::parse($request->tgl_mulai)->year)
                ->increment('cuti_terpakai', $lama);
        });

        return redirect()->route('cuti.index');
    }

    // Hapus pengajuan + rollback sisa
    public function destroy(CutiRequest $cuti)
    {
        $user = auth()->user();

        abort_unless($user->id === $cuti->user_id || $user->role === 'Manajer', 403);

        DB::transaction(function () use ($cuti) {
            // Kurangi terpakai
            SisaCuti::where('user_id', $cuti->user_id)
                ->where('tahun', Carbon::parse($cuti->tanggal_mulai)->year)
                ->decrement('cuti_terpakai', $cuti->lama_cuti);

            // Hapus log & request (cascade FK)
            $cuti->delete();
        });

        return redirect()->route('cuti.index');
    }

    // Approve oleh Manajer
    public function accept(CutiRequest $cuti)
    {
        $user = auth()->user();
        abort_unless($user->role === 'Manajer', 403);

        DB::transaction(function () use ($cuti, $user) {
            $cuti->update([
                'status'           => 'Disetujui',
                'disetujui_oleh'   => $user->id,
                'tanggal_disetujui'=> now()->toDateString(),
            ]);

            CutiLogs::create([
                'cuti_request_id' => $cuti->id,
                'aksi'            => 'Disetujui',
                'oleh_user_id'    => $user->id,
                'keterangan'      => 'Diterima oleh Manajer',
            ]);
        });

        return redirect()->route('cuti.index');
    }

      public function sisaIndex()
    {
        // ambil semua record SisaCuti (atau sesuaikan dengan role/user)
        $rekap = SisaCuti::with('user')->orderBy('tahun', 'desc')->get();
        return view('cuti.sisa_index', compact('rekap'));
    }

    /**
     * Update sisa cuti manual (misal di Manajer)
     */
    public function sisaUpdate(Request $request, SisaCuti $sisa)
    {
        $request->validate([
            'cuti_sisa'     => 'required|integer|min:0',
            'cuti_terpakai' => 'required|integer|min:0',
        ]);

        $sisa->update($request->only(['cuti_sisa','cuti_terpakai']));
        return redirect()->route('cuti.sisa.index')
                         ->with('success','Rekap sisa cuti berhasil di-update.');
    }
}
