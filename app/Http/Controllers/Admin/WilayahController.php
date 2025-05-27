<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wilayahs = Wilayah::orderBy('nama_wilayah', 'asc')->paginate(10);
        return view('admin.wilayah.index', compact('wilayahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $parents = Wilayah::orderBy('nama_wilayah')->get();
        // return view('admin.wilayah.create', compact('parents'));
        return view('admin.wilayah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_wilayah' => 'nullable|string|max:20|unique:wilayah,kode_wilayah',
            'nama_wilayah' => 'required|string|max:255',
            // 'parent_id' => 'nullable|exists:wilayah,id', // Validasi jika parent_id diaktifkan
        ]);

        try {
            Wilayah::create($validatedData);

            return redirect()->route('admin.wilayah.index')->with('success', 'Wilayah baru berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Log::error('Gagal menyimpan wilayah: ' . $e->getMessage()); // Anda perlu use Illuminate\Support\Facades\Log;

            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan wilayah. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Wilayah $wilayah)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wilayah $wilayah)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wilayah $wilayah)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wilayah $wilayah)
    {
        //
    }
}
