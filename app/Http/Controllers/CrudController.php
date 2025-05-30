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
use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CrudController extends Controller
{
    // === OPERATOR (Users) ===

    public function usersIndex(Request $request)
    {
        $search = $request->get('search');

        $users = User::where('role', 'Operator')
            ->when($search, fn($q) => 
                $q->where(function($q2) use ($search) {
                    $q2->where('name',   'like', "%{$search}%")
                        ->orWhere('divisi','like', "%{$search}%");
                })
            )
            ->orderBy('name')
            ->get();

        if ($request->ajax()) {
            return view('operator', ['Operator' => $users])->render();
        }

        return view('index.operator', ['Operator' => $users]);
    }

    public function usersEdit($id)
    {
        $user = User::findOrFail($id);
        return view('index.modal_edit', compact('user'));
    }

    public function usersUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $id,
            'role' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'alamat' => 'nullable|string|max:255',
            'joined_at' => 'nullable|date',
            'education' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'job_descriptions' => 'nullable|string',
            'skills' => 'nullable|string|max:255',
            'achievements' => 'nullable|string',
            'divisi' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Ambil hanya field yang diizinkan
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
            'divisi',
        ]);

        // Jika ada file 'photo', simpan di storage dan set ke data
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo_url) {
                Storage::delete(str_replace('/storage/', 'public/', $user->photo_url));
            }
            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            $data['photo_url'] = '/storage/' . $path;
        }

        // Jika password diisi, hash dan masukkan ke data
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update model dengan data
        $user->update($data);

        return redirect()
               ->route('operator.index')
               ->with('success', 'Data berhasil diperbarui.');
    }

    public function usersDestroy($id)
    {
        $user = User::findOrFail($id);

        // Pastikan user yang dihapus adalah Operator
        if ($user->role !== 'Operator') {
            return back()->with('error', 'Hanya operator yang dapat dihapus.');
        }

        // Hapus foto jika ada
        if ($user->photo_url) {
            Storage::delete(str_replace('/storage/', 'public/', $user->photo_url));
        }

        // Hapus data terkait
        SisaCuti::where('user_id', $id)->delete();
        CutiRequest::where('user_id', $id)->delete();
        CutiLogs::where('oleh_user_id', $id)->delete();
        Payroll::where('user_id', $id)->delete();
        Shift::where('user_id', $id)->delete();
        Feedback::where('user_id', $id)->orWhere('disetujui_oleh', $id)->delete();

        // Hapus user
        $user->delete();

        return redirect()
               ->route('operator.index')
               ->with('success', 'Operator berhasil dihapus.');
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

    // === Feedback ===
    public function feedbackIndex()
    {
        if (auth()->user()->role !== 'Operator') {
            $pegawai = User::where('role', '=', 'Operator')
                ->orderBy('name')
                ->get();
            return view('index.feedback_pegawai', compact('pegawai'));
        } else {
            $feedback = Feedback::where('user_id', '=', auth()->id())
                ->orderBy('tanggal_pengajuan', 'desc')
                ->get();

            $username = User::whereIn('id', Feedback::pluck('disetujui_oleh'))
                ->orderBy('name')
                ->get();
            return view('index.feedback_receive', compact('feedback', 'username'));
        }
    }

    public function feedbackStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'feedback_text' => 'required|string|max:1000',
        ]);

        Feedback::create([
            'user_id' => $request->user_id,
            'feedback_text' => $request->feedback_text,
            'tanggal_pengajuan' => Carbon::now()->toDateString(),
            'disetujui_oleh' => auth()->id()
        ]);

        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil dikirim.');
    }

    public function showCreateOperatorForm()
    {
        return view('index.modal_create_operator');
    }

    public function createOperatorBaru(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string',
            'alamat' => 'nullable|string|max:255',
            'joined_at' => 'nullable|date',
            'education' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'job_descriptions' => 'nullable|string',
            'skills' => 'nullable|string|max:255',
            'achievements' => 'nullable|string',
            'divisi' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Siapkan data untuk dibuat
        $data = $request->only([
            'name',
            'email',
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
            'divisi',
        ]);

        // Set role sebagai Operator
        $data['role'] = 'Operator';
        
        // Hash password
        $data['password'] = Hash::make($request->password);

        // Handle upload foto jika ada
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            $data['photo_url'] = '/storage/' . $path;
        }

        // Buat user baru
        $user = User::create($data);

        // Buat entri sisa cuti default untuk user baru
       SisaCuti::create([
    'user_id' => $user->id,
    'total_cuti' => 12,
    'cuti_terpakai' => 0,
    'tahun' => now()->year // Menggunakan tahun saat ini, misalnya 2025
]);

        return redirect()
            ->route('operator.index')
            ->with('success', 'Operator baru berhasil ditambahkan.');
    }
}