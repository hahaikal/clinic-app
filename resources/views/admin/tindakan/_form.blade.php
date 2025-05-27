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
    <label for="kode_tindakan" class="block text-sm font-medium text-gray-700">Kode Tindakan</label>
    <input type="text" name="kode_tindakan" id="kode_tindakan" value="{{ old('kode_tindakan', $tindakan->kode_tindakan ?? '') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           autocomplete="off">
</div>

<div class="mb-4">
    <label for="nama_tindakan" class="block text-sm font-medium text-gray-700">Nama Tindakan <span class="text-red-500">*</span></label>
    <input type="text" name="nama_tindakan" id="nama_tindakan" value="{{ old('nama_tindakan', $tindakan->nama_tindakan ?? '') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           required autocomplete="off">
</div>

<div class="mb-4">
    <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp) <span class="text-red-500">*</span></label>
    <input type="number" name="harga" id="harga" value="{{ old('harga', $tindakan->harga ?? '0') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           required step="any">
</div>

<div>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        {{ $tombol_submit ?? 'Simpan' }}
    </button>
    <a href="{{ route('admin.tindakan.index') }}" class="ml-2 inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
        Batal
    </a>
</div>