<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::with(['user.role'])
                            ->orderBy('nama_pegawai', 'asc')
                            ->paginate(10);

        return view('admin.pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('pegawai')
                 ->orderBy('name', 'asc')
                 ->get();

        return view('admin.pegawai.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:pegawai,nip',
            'jabatan' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'user_id' => 'nullable|integer|exists:users,id|unique:pegawai,user_id',
        ]);

        try {
            Pegawai::create($validatedData);

            return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan data pegawai. Silakan coba lagi.');
        }
    }

    public function show(Pegawai $pegawai)
    {
        //
    }

    public function edit(Pegawai $pegawai) 
    {
        $users = User::whereDoesntHave('pegawai')
                    ->orWhere('id', $pegawai->user_id)
                    ->orderBy('name', 'asc')
                    ->get();

        return view('admin.pegawai.edit', compact('pegawai', 'users'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $validatedData = $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:pegawai,nip,' . $pegawai->id,
            'jabatan' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'user_id' => 'nullable|integer|exists:users,id|unique:pegawai,user_id,' . $pegawai->id . ',id,user_id,' . ($request->user_id ? $request->user_id : 'NULL'),
        ]);

        if ($request->filled('user_id')) {
            $request->validate([
                'user_id' => 'exists:users,id|unique:pegawai,user_id,' . $pegawai->id,
            ]);
        } else {
            $request->validate([
                'user_id' => 'nullable',
            ]);
        }

        try {
            $updateData = $validatedData;
            if (!$request->filled('user_id')) {
                $updateData['user_id'] = null;
            }

            $pegawai->update($updateData);

            return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data pegawai. Silakan coba lagi.');
        }
    }

    public function destroy(Pegawai $pegawai)
    {
        try {
            $pegawai->delete();
            return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->route('admin.pegawai.index')->with('error', 'Gagal menghapus data pegawai.');
        }
    }
}
