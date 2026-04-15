<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;


class UsersController extends Controller
{
    /**
     * index untuk menampilkan daftar user berdasarkan role (Admin)
     */
    public function indexAdmin()
    {
        $users = User::where('role', 'admin')->get();
        return view('admin.useradmin.index', compact('users'));
    }

    /**
     * index untuk menampilkan daftar user berdasarkan role (Admin)
     */
    public function indexStaff()
    {
        $users = User::where('role', 'staff')->get();
        return view('admin.userstaff.index', compact('users'));
    }

    /**
     * Form tambah user baru
     */
    public function create()
    {
        return view('admin.useradmin.create');
    }

    /**
     * Simpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role'  => 'required|in:admin,staff',
        ]);

        // Password default: 4 karakter pertama email + id (akan di-update setelah insert)
        $emailPrefix = strtolower(substr($request->email, 0, 4));

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => strtolower($request->role),
            'password' => 'temp_password',
        ]);

        // Update password setelah dapat id
        $defaultPassword = $emailPrefix . $user->id;
        $user->update(['password' => $defaultPassword]);

        $redirectRoute = strtolower($request->role) === 'admin' ? 'users.admin' : 'users.staff';

        return redirect()->route($redirectRoute)
                         ->with('success', "User berhasil dibuat. Password default: {$defaultPassword}");
    }

    /**
     * Form edit user (Admin)
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.useradmin.edit', compact('user'));
    }

    /**
     * Update user oleh Admin
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        // Ubah password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('users.admin')
                         ->with('success', 'Data user berhasil diupdate.');
    }

    /**
     * Hapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Jangan bisa hapus diri sendiri
        if ($user->id === Auth::id()) {
            return back()->with('failed', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }

    /**
     * Reset password user ke default (4 karakter email + id)
     */
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);

        $emailPrefix    = strtolower(substr($user->email, 0, 4));
        $newPassword    = $emailPrefix . $user->id;

        $user->update(['password' => $newPassword]);

        return back()->with('success', "Password direset ke: {$newPassword}");
    }

    /**
     * Form edit profil untuk Staff
     */
    public function editProfile()
    {
        $user = Auth::user();

        return view('staff.users.edit', compact('user'));
    }

    /**
     * Update profil Staff sendiri
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('staff.dashboard')
                         ->with('success', 'Profil berhasil diupdate.');
    }

    public function export(Request $request)
    {
        $role = $request->query('role', 'admin');
        return Excel::download(new UserExport($role), $role . '-accounts.xlsx');
    }

     public function exportStaff(Request $request)
    {
        $role = $request->query('role', 'staff');
        return Excel::download(new UserExport($role), $role . '-accounts.xlsx');
    }

}
