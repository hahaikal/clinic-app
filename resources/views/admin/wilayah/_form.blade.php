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

<div class="mb-4 text-gray-700">
    <label for="kode_wilayah" class="block text-sm font-medium text-gray-700">Kode Wilayah</label>
    <input type="text" name="kode_wilayah" id="kode_wilayah" value="{{ old('kode_wilayah', $wilayah->kode_wilayah ?? '') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           autocomplete="off">
</div>

<div class="mb-4 text-gray-700">
    <label for="nama_wilayah" class="block text-sm font-medium text-gray-700">Nama Wilayah <span class="text-red-500">*</span></label>
    <input type="text" name="nama_wilayah" id="nama_wilayah" value="{{ old('nama_wilayah', $wilayah->nama_wilayah ?? '') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           required autocomplete="off">
</div>

<div>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-gray-700 font-bold py-2 px-4 rounded">
        {{ $tombol_submit ?? 'Simpan' }}
    </button>
    <a href="{{ route('admin.wilayah.index') }}" class="ml-2 inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
        Batal
    </a>
</div>