<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index()
    {
        $wilayahs = Wilayah::orderBy('nama_wilayah', 'asc')->paginate(10);
        return view('admin.wilayah.index', compact('wilayahs'));
    }

    public function create()
    {
        return view('admin.wilayah.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_wilayah' => 'nullable|string|max:20|unique:wilayah,kode_wilayah',
            'nama_wilayah' => 'required|string|max:255',
        ]);

        try {
            Wilayah::create($validatedData);

            return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan wilayah. Silakan coba lagi.');
        }
    }

    public function show(Wilayah $wilayah)
    {
        //
    }

    public function edit(Wilayah $wilayah)
    {
        return view('admin.wilayah.edit', compact('wilayah'));
    }

    public function update(Request $request, Wilayah $wilayah)
    {
        $validatedData = $request->validate([
            'kode_wilayah' => 'nullable|string|max:20|unique:wilayah,kode_wilayah,' . $wilayah->id,
            'nama_wilayah' => 'required|string|max:255',
        ]);

        try {
            $wilayah->update($validatedData);

            return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui wilayah. Silakan coba lagi.');
        }
    }

    public function destroy(Wilayah $wilayah)
    {
        try {
            $wilayah->delete();

            return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = 'Gagal menghapus wilayah.';
        
            if (str_contains($e->getMessage(), 'violates foreign key constraint')) {
                $errorMessage = 'Gagal menghapus wilayah karena masih digunakan oleh data lain.';
            }
            
            return redirect()->route('admin.wilayah.index')->with('error', $errorMessage);
        } catch (\Exception $e) {
            return redirect()->route('admin.wilayah.index')->with('error', 'Gagal menghapus wilayah. Silakan coba lagi.');
        }
    }
}

