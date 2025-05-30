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
        $minDate = now()->addDays(7)->toDateString();

        $request->validate([
            'tgl_mulai'   => [
            'required',
            'date',
            "after_or_equal:{$minDate}"
            ],
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'alasan'      => 'required|string',
        ], [
            'tgl_mulai.after_or_equal' => 'Tanggal mulai cuti harus minimal 7 hari setelah hari pengajuan',
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

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil dibuat.');
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
            ->with('success', 'Riwayat cuti berhasil dihapus.');
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
        $user = $cuti->user;
        $lama = $cuti->lama_cuti;
        $tahun = Carbon::parse($cuti->tanggal_mulai)->year;

        DB::transaction(function () use ($cuti, $user, $lama, $tahun) {
            // Memulihkan sisa cuti
            SisaCuti::where('user_id', $user->id)
                ->where('tahun', $tahun)
                ->update([
                    'cuti_terpakai' => DB::raw("cuti_terpakai - {$lama}"),
                    'cuti_sisa'     => DB::raw("cuti_sisa + {$lama}"),
                ]);

            // Mengubah status menjadi 'Ditolak'
            $cuti->status = 'Ditolak';
            $cuti->save();

            // Mencatat log penolakan
            CutiLogs::create([
                'cuti_request_id' => $cuti->id,
                'aksi'            => 'Ditolak',
                'oleh_user_id'    => auth()->user()->id,
                'keterangan'      => 'Pengajuan ditolak oleh Manajer',
            ]);
        });

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti ditolak.');
    }

    // Batalkan pengajuan
    public function batal($id)
    {
        $cuti = CutiRequest::findOrFail($id);
        $user = auth()->user();

        // Hanya pemilik pengajuan yang boleh membatalkan dan hanya jika status masih 'Menunggu'
        abort_unless($user->id === $cuti->user_id && $cuti->status === 'Menunggu', 403);

        $lama = $cuti->lama_cuti;
        $tahun = Carbon::parse($cuti->tanggal_mulai)->year;

        DB::transaction(function () use ($cuti, $user, $lama, $tahun) {
            // Kembalikan sisa cuti
            SisaCuti::where('user_id', $user->id)
                ->where('tahun', $tahun)
                ->update([
                    'cuti_terpakai' => DB::raw("cuti_terpakai - {$lama}"),
                    'cuti_sisa'     => DB::raw("cuti_sisa + {$lama}"),
                ]);

            // Ubah status menjadi 'Dibatalkan'
            $cuti->delete();
        });

        return redirect()->route('cuti.index')->with('success', 'Pengajuan cuti berhasil dibatalkan.');
    }

    // Memeriksa apakah ada pengajuan cuti yang sedang menunggu
    public function hasPendingRequests()
    {
        $user = auth()->user();

        $query = CutiRequest::where('status', 'Menunggu');

        // Jika bukan Manajer, hanya periksa pengajuan milik pengguna
        if ($user->role !== 'Manajer') {
            $query->where('user_id', $user->id);
        }

        // Mengembalikan true jika ada pengajuan dengan status Menunggu
        return $query->exists();
    }

    // Memeriksa apakah pengguna non-Manajer memiliki pengajuan dengan status selain Menunggu
    public function hasNonPendingRequests()
    {
        $user = auth()->user();

        if ($user->role !== 'Manajer') {
            return CutiRequest::where('user_id', $user->id)
                ->where('status', '!=', 'Menunggu')
                ->where('dilihat', false) // Hanya yang belum dilihat
                ->exists();
        }

        return false;
    }

    public function markAsRead()
    {
        $user = auth()->user();

        // Hanya untuk non-Manajer
        if ($user->role !== 'Manajer') {
            // Update semua cuti non-pending menjadi status 'dilihat'
            CutiRequest::where('user_id', $user->id)
                ->where('status', '!=', 'Menunggu')
                ->where('dilihat', false)
                ->update(['dilihat' => true]);
        }

        return response()->json(['success' => true]);
    }
}
