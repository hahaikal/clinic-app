<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')->orderBy('name', 'asc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('name', 'asc')->get();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email', // unik di tabel users
            'password' => 'required|string|min:8|confirmed', // 'confirmed' akan mencocokkan dengan 'password_confirmation'
            'role_id' => 'required|exists:roles,id', // role_id harus ada di tabel roles
        ]);

        // 2. Simpan Data ke Database
        try {
            User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']), // Hash password sebelum disimpan
                'role_id' => $validatedData['role_id'],
                'email_verified_at' => now(), // Anggap user yang dibuat Admin langsung terverifikasi
            ]);

            // 3. Redirect dengan Pesan Sukses
            return redirect()->route('admin.users.index')->with('success', 'User baru berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Log::error('Gagal menyimpan user: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan user. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::orderBy('name', 'asc')->get(); // Ambil semua role untuk dropdown
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $updateData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role_id' => $validatedData['role_id'],
        ];

        if (!empty($validatedData['password'])) {
            $updateData['password'] = Hash::make($validatedData['password']);
        }
        try {
            $user->update($updateData);

            return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui user. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
    if (Auth::id() === $user->id) {
        return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
    }

    try {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');

    } catch (\Exception $e) {
        return redirect()->route('admin.users.index')->with('error', 'Gagal menghapus user. Mungkin user ini terkait dengan data lain.');
    }
}
}
