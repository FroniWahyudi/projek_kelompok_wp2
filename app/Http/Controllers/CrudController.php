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
    // === USERS BY ROLE (CRUD for all roles) ===

    // Method untuk menampilkan users berdasarkan role
    public function usersByRole(Request $request, $role)
    {
        $search = $request->get('search');
        $validRoles = ['Admin', 'Manager', 'Leader', 'Operator'];
        
        if (!in_array($role, $validRoles)) {
            abort(404, 'Role not found');
        }

        $users = User::where('role', $role)
            ->when($search, fn($q) =>
                $q->where(function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                        ->orWhere('divisi', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
            )
            ->orderBy('name')
            ->get();

        // Untuk AJAX request
        if ($request->ajax()) {
            $viewName = strtolower($role);
            return view($viewName, ['users' => $users])->render();
        }

        // Return view berdasarkan role
        $viewName = 'index.' . strtolower($role);
        return view($viewName, ['users' => $users]);
    }

    // Method khusus untuk backward compatibility
    public function usersIndex(Request $request)
    {
        return $this->usersByRole($request, 'Operator');
    }

    public function managerIndex(Request $request)
    {
        return $this->usersByRole($request, 'Manager');
    }

   public function leaderIndex(Request $request)
{
    $leaderCount = $this->hitungLeader(); // Panggil method hitungLeader
    $users = User::where('role', 'Leader')
        ->when($request->get('search'), fn($q) =>
            $q->where(function ($q2) use ($request) {
                $search = $request->get('search');
                $q2->where('name', 'like', "%{$search}%")
                    ->orWhere('divisi', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
        )
        ->orderBy('name')
        ->get();

    return view('index.leader', compact('users', 'leaderCount'));
}

    public function adminIndex(Request $request)
    {
        $adminCount = $this->hitungAdmin(); // Panggil method hitungAdmin
        $users = User::where('role', 'Admin')
            ->when($request->get('search'), fn($q) =>
                $q->where(function ($q2) use ($request) {
                    $search = $request->get('search');
                    $q2->where('name', 'like', "%{$search}%")
                        ->orWhere('divisi', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
            )
            ->orderBy('name')
            ->get();

        return view('index.admin', compact('users', 'adminCount'));
    }

    // Tambahkan method hitungAdmin
    public function hitungAdmin()
    {
        return User::where('role', 'Admin')->count();
    }

    // === GENERAL EDIT METHODS ===

    // Method general untuk edit user berdasarkan role
    public function editUser($role, $id)
    {
        $validRoles = ['Admin', 'Manager', 'Leader', 'Operator'];
        
        if (!in_array($role, $validRoles)) {
            abort(404, 'Role not found');
        }

        $user = User::where('role', $role)->findOrFail($id);
        
        // Return view berdasarkan role
        $viewName = 'index.modal_edit_' . strtolower($role);
        return view($viewName, compact('user'));
    }

    // Method specific untuk backward compatibility
    public function usersEdit($id)
    {
        return $this->editUser('Operator', $id);
    }

    public function leaderEdit($id)
    {
        return $this->editUser('Leader', $id);
    }

    public function managerEdit($id)
    {
        return $this->editUser('Manager', $id);
    }

    public function adminEdit($id)
    {
        return $this->editUser('Admin', $id);
    }

    // === GENERAL UPDATE METHODS ===

    // Method general untuk update user berdasarkan role
    public function updateUser(Request $request, $role, $id)
    {
        $validRoles = ['Admin', 'Manager', 'Leader', 'Operator'];
        
        if (!in_array($role, $validRoles)) {
            abort(404, 'Role not found');
        }

        $user = User::where('role', $role)->findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $id,
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
            'email_username' => 'nullable|string|regex:/^[a-zA-Z0-9._-]+$/',
        ]);

        // Ambil hanya field yang diizinkan
        $data = $request->only([
            'name',
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

        // Handle email dari username
        if ($request->filled('email_username')) {
            $data['email'] = $request->email_username . '@nagahytam.co.id';
        } elseif ($request->filled('email')) {
            $data['email'] = $request->email;
        }

        // Role tetap sesuai dengan parameter (tidak bisa diubah melalui method ini)
        $data['role'] = $role;

        // Handle upload foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->photo_url) {
                Storage::delete(str_replace('/storage/', 'public/', $user->photo_url));
            }
            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            $data['photo_url'] = '/storage/' . $path;
        }

        // Hash password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Update user
        $user->update($data);

        // Redirect berdasarkan role
        $redirectRoute = $this->getRedirectRoute($role);
        
        return redirect()
            ->route($redirectRoute)
            ->with('success', "Data {$role} berhasil diperbarui.");
    }

    // Method specific untuk backward compatibility
    public function usersUpdate(Request $request, $id)
    {
        return $this->updateUser($request, 'Operator', $id);
    }

    public function leaderUpdate(Request $request, $id)
    {
        return $this->updateUser($request, 'Leader', $id);
    }

    public function managerUpdate(Request $request, $id)
    {
        return $this->updateUser($request, 'Manager', $id);
    }

    public function adminUpdate(Request $request, $id)
    {
        return $this->updateUser($request, 'Admin', $id);
    }

    // === GENERAL DELETE METHODS ===

    // Method general untuk delete user berdasarkan role
    public function destroyUser($role, $id)
    {
        $validRoles = ['Admin', 'Manager', 'Leader', 'Operator'];
        
        if (!in_array($role, $validRoles)) {
            abort(404, 'Role not found');
        }

        $user = User::where('role', $role)->findOrFail($id);

        // Cegah hapus Admin terakhir
        if ($role === 'Admin' && User::where('role', 'Admin')->count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus Admin terakhir.');
        }

        // Hapus foto jika ada
        if ($user->photo_url) {
            Storage::delete(str_replace('/storage/', 'public/', $user->photo_url));
        }

        // Hapus user
        $user->delete();

        // Redirect berdasarkan role
        $redirectRoute = $this->getRedirectRoute($role);

        return redirect()
            ->route($redirectRoute)
            ->with('success', "{$role} berhasil dihapus.");
    }

    // Method specific untuk backward compatibility
    public function usersDestroy($id)
    {
        return $this->destroyUser('Operator', $id);
    }

    public function leaderDestroy($id)
    {
        return $this->destroyUser('Leader', $id);
    }

    public function managerDestroy($id)
    {
        return $this->destroyUser('Manager', $id);
    }

    public function adminDestroy($id)
    {
        return $this->destroyUser('Admin', $id);
    }

    // === CREATE USER METHODS ===

    // Method untuk create user dengan role tertentu
    public function createUser(Request $request, $role = null)
    {
        // Jika role tidak diberikan sebagai parameter, ambil dari request
        if (!$role) {
            $role = $request->input('role', 'Operator');
        }

        $validRoles = ['Admin', 'Manager', 'Leader', 'Operator'];
        
        if (!in_array($role, $validRoles)) {
            return back()->withErrors(['role' => 'Role tidak valid.']);
        }

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
            'email_username' => 'nullable|string|regex:/^[a-zA-Z0-9._-]+$/',
        ]);

        // Siapkan data untuk dibuat
        $data = $request->only([
            'name',
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

        // Handle email dari username
        if ($request->filled('email_username')) {
            $data['email'] = $request->email_username . '@nagahytam.co.id';
        } else {
            $data['email'] = $request->email;
        }

        // Set role
        $data['role'] = $role;

        // Hash password
        $data['password'] = Hash::make($request->password);

        // Handle upload foto jika ada
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $path = $file->store('photos', 'public');
            $data['photo_url'] = '/storage/' . $path;
        }

        // Generate id_karyawan
        $joined_at = $request->joined_at ?? now();
        $year = Carbon::parse($joined_at)->format('Y');
        $prefix = 'NHSA';
        $count = User::where('id_karyawan', 'like', $prefix . $year . '%')->count() + 1;
        $nomorUrut = str_pad($count, 3, '0', STR_PAD_LEFT);
        $data['id_karyawan'] = $prefix . $year . $nomorUrut;

        // Buat user baru
        $user = User::create($data);

        // Buat entri sisa cuti default untuk user baru (khusus untuk role yang memerlukan cuti)
        if (in_array($user->role, ['Manager', 'Leader', 'Operator'])) {
            SisaCuti::create([
                'user_id' => $user->id,
                'total_cuti' => 12,
                'cuti_terpakai' => 0,
                'tahun' => now()->year
            ]);
        }

        // Redirect berdasarkan role
        $redirectRoute = $this->getRedirectRoute($user->role);

        return redirect()
            ->route($redirectRoute)
            ->with('success', "{$user->role} baru berhasil ditambahkan.");
    }

    // Method khusus untuk create dengan role spesifik
    public function createAdmin(Request $request)
    {
        return $this->createUser($request, 'Admin');
    }

    public function createManager(Request $request)
    {
        return $this->createUser($request, 'Manager');
    }

    public function createLeader(Request $request)
    {
        return $this->createUser($request, 'Leader');
    }

    public function createOperator(Request $request)
    {
        return $this->createUser($request, 'Operator');
    }

    // Method khusus untuk create operator (backward compatibility)
    public function createOperatorBaru(Request $request)
    {
        return $this->createOperator($request);
    }

    // Method untuk show form create berdasarkan role
    public function showCreateForm($role = 'Operator')
    {
        $validRoles = ['Admin', 'Manager', 'Leader', 'Operator'];
        
        if (!in_array($role, $validRoles)) {
            abort(404, 'Role not found');
        }

        return view('index.modal_create_user', compact('role'));
    }

    // === HELPER METHODS ===

    // Helper method untuk mendapatkan route redirect berdasarkan role
    private function getRedirectRoute($role)
    {
        return match($role) {
            'Admin' => 'admin.index',
            'Manager' => 'manager.index',
            'Leader' => 'leader.index',
            'Operator' => 'operator.index',
            default => 'dashboard'
        };
    }

    // Method untuk mendapatkan semua users (untuk keperluan admin)
    public function getAllUsers(Request $request)
    {
        $search = $request->get('search');
        $role_filter = $request->get('role');

        $query = User::query();

        if ($role_filter && $role_filter !== 'all') {
            $query->where('role', $role_filter);
        }

        $users = $query->when($search, fn($q) =>
                $q->where(function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('divisi', 'like', "%{$search}%");
                })
            )
            ->orderBy('role')
            ->orderBy('name')
            ->get();

        return view('index.all_users', compact('users', 'role_filter'));
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
        $item->update($request->only(['total_cuti', 'cuti_terpakai']));
        return back()->with('success', 'Sisa cuti berhasil diupdate');
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
            'user_id', 'tanggal_pengajuan', 'tanggal_mulai',
            'tanggal_selesai', 'lama_cuti', 'alasan'
        ]));
        return redirect()->route('cuti_requests.index')->with('success', 'Permintaan cuti dibuat');
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
        return back()->with('success', 'Status cuti diperbarui');
    }

    public function cutiRequestsDestroy($id)
    {
        CutiRequest::destroy($id);
        return back()->with('success', 'Permintaan cuti dihapus');
    }

    // === CUTI LOGS ===

    public function cutiLogsIndex($reqId)
    {
        $logs = CutiLogs::where('cuti_request_id', $reqId)->orderBy('waktu')->get();
        return view('cuti_logs.index', compact('logs', 'reqId'));
    }

    public function cutiLogsStore(Request $request, $reqId)
    {
        CutiLogs::create([
            'cuti_request_id' => $reqId,
            'aksi' => $request->aksi,
            'oleh_user_id' => $request->oleh_user_id,
            'keterangan' => $request->keterangan
        ]);
        return back()->with('success', 'Log cuti ditambahkan');
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
        LaporanKerja::create($request->only(['tanggal', 'nama', 'divisi', 'deskripsi']));
        return redirect()->route('laporan_kerja.index')->with('success', 'Laporan kerja dibuat');
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
        News::create($request->only(['title', 'date', 'image_url', 'description', 'link']));
        return redirect()->route('news.index')->with('success', 'Berita dibuat');
    }

    // === PAYROLLS ===

    public function payrollsByUser($userId)
    {
        $list = Payroll::where('user_id', $userId)->get();
        return view('payrolls.index', compact('list', 'userId'));
    }

    public function payrollsStore(Request $request, $userId)
    {
        Payroll::create(array_merge(
            ['user_id' => $userId],
            $request->only(['periode', 'gaji_pokok', 'tunjangan', 'potongan', 'total_gaji'])
        ));
        return back()->with('success', 'Payroll ditambahkan');
    }

    // === SHIFTS KARYAWAN ===

    public function shiftsByUser($userId)
    {
        $shifts = Shift::where('user_id', $userId)->get();
        return view('shifts.index', compact('shifts', 'userId'));
    }

    public function shiftsStore(Request $request, $userId)
    {
        Shift::create(array_merge(
            ['user_id' => $userId],
            $request->only(['tanggal', 'shift'])
        ));
        return back()->with('success', 'Shift ditambahkan');
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

    public function hitungLeader()
{
    return User::where('role', 'Leader')->count();
}
}