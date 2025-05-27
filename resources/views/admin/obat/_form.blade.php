@if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <strong class="font-bold">Oops! Ada beberapa masalah dengan input Anda:</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-4">
    <label for="kode_obat" class="block text-sm font-medium text-gray-700">Kode Obat</label>
    <input type="text" name="kode_obat" id="kode_obat" value="{{ old('kode_obat', $obat->kode_obat ?? '') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           autocomplete="off">
</div>

<div class="mb-4">
    <label for="nama_obat" class="block text-sm font-medium text-gray-700">Nama Obat <span class="text-red-500">*</span></label>
    <input type="text" name="nama_obat" id="nama_obat" value="{{ old('nama_obat', $obat->nama_obat ?? '') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           required autocomplete="off">
</div>

<div class="mb-4">
    <label for="satuan" class="block text-sm font-medium text-gray-700">Satuan <span class="text-red-500">*</span></label>
    <input type="text" name="satuan" id="satuan" value="{{ old('satuan', $obat->satuan ?? '') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           required placeholder="Mis: Tablet, Botol, Strip, Pcs">
</div>

<div class="mb-4">
    <label for="harga_jual" class="block text-sm font-medium text-gray-700">Harga Jual (Rp) <span class="text-red-500">*</span></label>
    <input type="number" name="harga_jual" id="harga_jual" value="{{ old('harga_jual', $obat->harga_jual ?? '0') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           required step="any" min="0">
</div>

<div class="mb-4">
    <label for="stok" class="block text-sm font-medium text-gray-700">Stok <span class="text-red-500">*</span></label>
    <input type="number" name="stok" id="stok" value="{{ old('stok', $obat->stok ?? '0') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           required step="1" min="0">
</div>

<div>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        {{ $tombol_submit ?? 'Simpan' }}
    </button>
    <a href="{{ route('admin.obat.index') }}" class="ml-2 inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
        Batal
    </a>
</div>