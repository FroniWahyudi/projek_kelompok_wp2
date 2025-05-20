<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SisaCuti;
use App\Models\CutiRequest;
use App\Models\CutiLogs;
use App\Models\LaporanKerja;
use App\Models\News;
use App\Models\Payroll;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CrudController extends Controller
{
    // === OPERATOR (Users) ===

    public function usersIndex(Request $request)
    {
        $users = User::where('role', 'Operator')
                     ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%"))
                     ->orderBy('id')
                     ->get();

        if ($request->ajax()) {
            return view('operator', ['Operator' => $users]);
        }

        return view('operator', ['Operator' => $users]);
    }

    public function usersEdit($id)
    {
        $user = User::findOrFail($id);
        return view('index.modal_edit', compact('user'));
    }

public function usersUpdate(Request $request, $id)
{
    $user = User::findOrFail($id);

    // Ambil hanya field-field yang ada di form
    $data = $request->only([
        'name',
        'email',
        'role',
        'phone',
        'bio',
        'alamat',
        'joined_at',
        'education',
        'department',
        'level',
        'job_descriptions',
        'skills',
        'achievements',
        'divisi',  // ← Tambahkan ini
    ]);

    // Jika ada file 'photo', simpan di storage dan set ke data
    if ($request->hasFile('photo')) {
        $file     = $request->file('photo');
        $path     = $file->store('photos', 'public');
        $data['photo_url'] = '/storage/' . $path;
    }

    // Jika password diisi, hash dan masukkan ke data
    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    // Update model dengan semua data, termasuk photo_url kalau ada
    $user->update($data);

    return redirect()
           ->route('operator.index')
           ->with('success', 'Data berhasil diperbarui.');
}


    // === SISA CUTI ===

    public function sisaCutiIndex()
    {
        $list = SisaCuti::all();
        return view('sisa_cuti.index', compact('list'));
    }

    public function sisaCutiUpdate(Request $request, $id)
    {
        $item = SisaCuti::findOrFail($id);
        $item->update($request->only(['total_cuti','cuti_terpakai']));
        return back()->with('success','Sisa cuti berhasil diupdate');
    }

    // === CUTI REQUESTS ===

    public function cutiRequestsIndex()
    {
        $items = CutiRequest::all();
        return view('cuti_requests.index', compact('items'));
    }

    public function cutiRequestsCreate()
    {
        return view('cuti_requests.create');
    }

    public function cutiRequestsStore(Request $request)
    {
        CutiRequest::create($request->only([
            'user_id','tanggal_pengajuan','tanggal_mulai',
            'tanggal_selesai','lama_cuti','alasan'
        ]));
        return redirect()->route('cuti_requests.index')->with('success','Permintaan cuti dibuat');
    }

    public function cutiRequestsShow($id)
    {
        $item = CutiRequest::findOrFail($id);
        return view('cuti_requests.show', compact('item'));
    }

    public function cutiRequestsUpdateStatus(Request $request, $id)
    {
        $req = CutiRequest::findOrFail($id);
        $req->update([
            'status' => $request->status,
            'disetujui_oleh' => $request->disetujui_oleh,
            'tanggal_disetujui' => now()
        ]);
        return back()->with('success','Status cuti diperbarui');
    }

    public function cutiRequestsDestroy($id)
    {
        CutiRequest::destroy($id);
        return back()->with('success','Permintaan cuti dihapus');
    }

    // === CUTI LOGS ===

    public function cutiLogsIndex($reqId)
    {
        $logs = CutiLogs::where('cuti_request_id', $reqId)->orderBy('waktu')->get();
        return view('cuti_logs.index', compact('logs','reqId'));
    }

    public function cutiLogsStore(Request $request, $reqId)
    {
        CutiLogs::create([
            'cuti_request_id' => $reqId,
            'aksi' => $request->aksi,
            'oleh_user_id' => $request->oleh_user_id,
            'keterangan' => $request->keterangan
        ]);
        return back()->with('success','Log cuti ditambahkan');
    }

    // === LAPORAN KERJA ===

    public function laporanIndex()
    {
        $laporan = LaporanKerja::all();
        return view('laporan_kerja.index', compact('laporan'));
    }

    public function laporanCreate()
    {
        return view('laporan_kerja.create');
    }

    public function laporanStore(Request $request)
    {
        LaporanKerja::create($request->only(['tanggal','nama','divisi','deskripsi']));
        return redirect()->route('laporan_kerja.index')->with('success','Laporan kerja dibuat');
    }

    // === NEWS ===

    public function newsIndex()
    {
        $news = News::all();
        return view('news.index', compact('news'));
    }

    public function newsCreate()
    {
        return view('news.create');
    }

    public function newsStore(Request $request)
    {
        News::create($request->only(['title','date','image_url','description','link']));
        return redirect()->route('news.index')->with('success','Berita dibuat');
    }

    // === PAYROLLS ===

    public function payrollsByUser($userId)
    {
        $list = Payroll::where('user_id', $userId)->get();
        return view('payrolls.index', compact('list','userId'));
    }

    public function payrollsStore(Request $request, $userId)
    {
        Payroll::create(array_merge(
            ['user_id' => $userId],
            $request->only(['periode','gaji_pokok','tunjangan','potongan','total_gaji'])
        ));
        return back()->with('success','Payroll ditambahkan');
    }

    // === SHIFTS KARYAWAN ===

    public function shiftsByUser($userId)
    {
        $shifts = Shift::where('user_id', $userId)->get();
        return view('shifts.index', compact('shifts','userId')); 
    }

    public function shiftsStore(Request $request, $userId)
    {
        Shift::create(array_merge(
            ['user_id' => $userId],
            $request->only(['tanggal','shift'])
        ));
        return back()->with('success','Shift ditambahkan');
    }
}
