<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tindakan;
use Illuminate\Http\Request;

class TindakanController extends Controller
{
    public function index()
    {
        $tindakans = Tindakan::orderBy('nama_tindakan', 'asc')->paginate(10);

        return view('admin.tindakan.index', compact('tindakans'));
    }

    public function create()
    {
        return view('admin.tindakan.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_tindakan' => 'nullable|string|max:50|unique:tindakan,kode_tindakan',
            'nama_tindakan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        try {
            Tindakan::create($validatedData);

            return redirect()->route('admin.tindakan.index')->with('success', 'Tindakan medis baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan tindakan medis. Silakan coba lagi.');
        }
    }

    public function show(Tindakan $tindakan)
    {
        //
    }

    public function edit(Tindakan $tindakan)
    {
        return view('admin.tindakan.edit', compact('tindakan'));
    }

    public function update(Request $request, Tindakan $tindakan)
    {
        $validatedData = $request->validate([
            'kode_tindakan' => 'nullable|string|max:50|unique:tindakan,kode_tindakan,' . $tindakan->id,
            'nama_tindakan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        try {
            $tindakan->update($validatedData);

            return redirect()->route('admin.tindakan.index')->with('success', 'Tindakan medis berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui tindakan medis. Silakan coba lagi.');
        }
    }

    public function destroy(Tindakan $tindakan)
    {
        try {
            $tindakan->delete();
            
            return redirect()->route('admin.tindakan.index')->with('success', 'Tindakan medis berhasil dihapus!');
        } catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = 'Gagal menghapus tindakan medis.';

            if (str_contains($e->getMessage(), 'violates foreign key constraint')) {
                $errorMessage = 'Gagal menghapus tindakan medis karena masih digunakan oleh data lain.';
            }

            return redirect()->route('admin.tindakan.index')->with('error', $errorMessage);
        } catch (\Exception $e) {
            return redirect()->route('admin.tindakan.index')->with('error', 'Gagal menghapus tindakan medis.');
        }
    }
}
