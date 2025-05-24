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
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = CutiRequest::with('user.sisaCuti');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($user->role !== 'Manajer') {
            $query->where('user_id', $user->id);
        }

        $query->orderByRaw("FIELD(status, 'Menunggu', 'Disetujui', 'Ditolak')")
              ->orderByDesc('tanggal_pengajuan');

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

        $user  = auth()->user();
        $start = Carbon::parse($request->tgl_mulai);
        $end   = Carbon::parse($request->tgl_selesai);
        $lama  = $start->diffInDays($end) + 1;
        $tahun = $start->year;

        // Ambil atau buat record sisa_cuti
        $sisa = SisaCuti::firstOrCreate(
            ['user_id' => $user->id, 'tahun' => $tahun],
            ['cuti_sisa' => 12, 'cuti_terpakai' => 0]
        );

        // Validasi sisa cuti cukup
        if ($sisa->cuti_sisa < $lama) {
            return back()->with('error', "Sisa cuti Anda hanya {$sisa->cuti_sisa} hari, permintaan {$lama} hari.");
        }

        DB::transaction(function () use ($user, $request, $lama, $tahun) {
            // Simpan pengajuan cuti
            $cuti = CutiRequest::create([
                'user_id'           => $user->id,
                'tanggal_pengajuan' => now()->toDateString(),
                'tanggal_mulai'     => $request->tgl_mulai,
                'tanggal_selesai'   => $request->tgl_selesai,
                'lama_cuti'         => $lama,
                'alasan'            => $request->alasan,
                'status'            => 'Menunggu',
            ]);

            // Log pembuatan pengajuan
            CutiLogs::create([
                'cuti_request_id' => $cuti->id,
                'aksi'            => 'Dibuat',
                'oleh_user_id'    => $user->id,
                'keterangan'      => 'Pengajuan dibuat',
            ]);

                        // Update sisa_cuti: tambah cuti_terpakai dan kurangi cuti_sisa sekaligus
            SisaCuti::where('user_id', $user->id)
                ->where('tahun', $tahun)
                ->update([
                    'cuti_terpakai' => DB::raw("cuti_terpakai + {$lama}"),
                    'cuti_sisa'     => DB::raw("cuti_sisa - {$lama}"),
                ]);
        });

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil dibuat dan sisa cuti terupdate.');
    }

    // Hapus pengajuan + rollback sisa cuti
public function destroy(CutiRequest $cuti)
{
    $user = auth()->user();
    abort_unless($user->id === $cuti->user_id || $user->role === 'Manajer', 403);

    DB::transaction(function () use ($cuti) {
        // Hapus dulu log terkait
        CutiLogs::where('cuti_request_id', $cuti->id)->delete();

        // Hapus pengajuan cuti
        $cuti->delete();
    });

    return redirect()
        ->route('cuti.index')
        ->with('success', 'Pengajuan cuti dan log terkait berhasil dihapus.');
}


    // Approve oleh Manajer
    public function accept(CutiRequest $cuti)
    {
        $user = auth()->user();
        abort_unless($user->role === 'Manajer', 403);

        DB::transaction(function () use ($cuti, $user) {
            $cuti->update([
                'status'            => 'Disetujui',
                'disetujui_oleh'    => $user->id,
                'tanggal_disetujui' => now()->toDateString(),
            ]);

            CutiLogs::create([
                'cuti_request_id' => $cuti->id,
                'aksi'            => 'Disetujui',
                'oleh_user_id'    => $user->id,
                'keterangan'      => 'Diterima oleh Manajer',
            ]);
        });

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti disetujui.');
    }

    // Tampilkan rekap sisa cuti
    public function sisaIndex()
    {
        $rekap = SisaCuti::with('user')
            ->orderBy('tahun', 'desc')
            ->get();

        return view('cuti.sisa_index', compact('rekap'));
    }

    // Update sisa cuti manual
    public function sisaUpdate(Request $request, SisaCuti $sisa)
    {
        $request->validate([
            'cuti_sisa'     => 'required|integer|min:0',
            'cuti_terpakai' => 'required|integer|min:0',
        ]);

        $sisa->update($request->only(['cuti_sisa', 'cuti_terpakai']));

        return redirect()->route('cuti.sisa.index')->with('success', 'Rekap sisa cuti berhasil di-update.');
    }

    // Reset tahunan
    public function resetTahunan()
    {
        DB::table('sisa_cuti')->update([
            'total_cuti'     => 12,
            'cuti_sisa'      => 12,
            'cuti_terpakai'  => 0,
        ]);

        return redirect()->route('cuti.index')->with('success', 'Cuti tahunan berhasil di-reset.');
    }

    // Reject pengajuan
    public function reject($id)
    {
        $cuti = CutiRequest::findOrFail($id);
        $cuti->status = 'Ditolak';
        $cuti->save();

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti ditolak.');
    }
}
