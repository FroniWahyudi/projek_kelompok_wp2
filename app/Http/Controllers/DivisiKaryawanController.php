<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\SisaCuti;
use App\Models\User;

use Illuminate\Http\Request;

class DivisiKaryawanController extends Controller
{

  //public create form
  public function showCreateForm($role = 'Operator')
    {
        $validRoles = ['Admin', 'Manager', 'Leader', 'Operator'];
        
        if (!in_array($role, $validRoles)) {
            abort(404, 'Role not found');
        }

        return view('index.modal_create_user', compact('role'));
    }

  // === GENERAL CREATE METHODS ===
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
    public function createManager(Request $request)
    {
        return $this->createUser($request, 'Manager');
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



    public function managerEdit($id)
    {
        return $this->editUser('Manager', $id);
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


    public function managerUpdate(Request $request, $id)
    {
        return $this->updateUser($request, 'Manager', $id);
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


    public function managerDestroy($id)
    {
        return $this->destroyUser('Manager', $id);
    }

    


  public function manajemen_index(){
    $managers = User::where('role', '=', 'Manajer')->first();

    // Ubah string jadi array agar bisa digunakan di @foreach di Blade
    $managers['jobs'] = explode(', ', $managers->job_descriptions);
    $managers['skills'] = explode(', ', $managers->skills);
    $managers['achievements'] = explode(', ', $managers->achievements);

    return view('index.manajemen', compact('managers'));
    }

    // divisi admin
    public function adminIndex(Request $request)
    {
        $adminCount = User::where('role', 'Admin')->count(); // Panggil method hitungAdmin
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

    public function createAdmin(Request $request)
    {
        return $this->createUser($request, 'Admin');
    }

    public function adminEdit($id)
    {
        return $this->editUser('Admin', $id);
    }

    public function adminUpdate(Request $request, $id)
    {
        return $this->updateUser($request, 'Admin', $id);
    }

    public function adminDestroy($id)
    {
        return $this->destroyUser('Admin', $id);
    }

    //divisi operator
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


    public function usersIndex(Request $request)
    {
        return $this->usersByRole($request, 'Operator');
    }

    public function createOperator(Request $request)
    {
        return $this->createUser($request, 'Operator');
    }

    public function usersEdit($id)
    {
        return $this->editUser('Operator', $id);
    }

    public function usersUpdate(Request $request, $id)
    {
        return $this->updateUser($request, 'Operator', $id);
    }

    public function usersDestroy($id)
    {
        return $this->destroyUser('Operator', $id);
    }

    //divisi leader
    public function leaderIndex(Request $request)
{
    $leaderCount = User::where('role', 'Leader')->count(); // Panggil method hitungLeader
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

    public function createLeader(Request $request)
    {
        return $this->createUser($request, 'Leader');
    }

    public function leaderEdit($id)
    {
        return $this->editUser('Leader', $id);
    }
    
    public function leaderUpdate(Request $request, $id)
    {
        return $this->updateUser($request, 'Leader', $id);
    }

    public function leaderDestroy($id)
    {
        return $this->destroyUser('Leader', $id);
    }
}
