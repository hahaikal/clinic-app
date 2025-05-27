<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::orderBy('nama_obat', 'asc')->paginate(10);
        return view('admin.obat.index', compact('obats'));
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_obat' => 'nullable|string|max:50|unique:obat,kode_obat',
            'nama_obat' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        try {
            Obat::create($validatedData);

            return redirect()->route('admin.obat.index')->with('success', 'Obat baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan obat. Silakan coba lagi.');
        }
    }

    public function show(Obat $obat)
    {
        //
    }

    public function edit(Obat $obat)
    {
        return view('admin.obat.edit', compact('obat'));
    }

    public function update(Request $request, Obat $obat)
    {
        $validatedData = $request->validate([
            'kode_obat' => 'nullable|string|max:50|unique:obat,kode_obat,' . $obat->id,
            'nama_obat' => 'required|string|max:255',
            'satuan' => 'required|string|max:50',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        try {
            $obat->update($validatedData);

            return redirect()->route('admin.obat.index')->with('success', 'Data obat berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data obat. Silakan coba lagi.');
        }
    }

    public function destroy(Obat $obat)
    {
        try {
            $obat->delete();
            
            return redirect()->route('admin.obat.index')->with('success', 'Data obat berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = 'Gagal menghapus data obat.';

            if (str_contains($e->getMessage(), 'violates foreign key constraint')) {
                $errorMessage = 'Gagal menghapus data obat karena masih digunakan oleh data lain.';
            }

            return redirect()->route('admin.obat.index')->with('error', $errorMessage);
        } catch (\Exception $e) {
            return redirect()->route('admin.obat.index')->with('error', 'Gagal menghapus data obat.');
        }
    }
}
