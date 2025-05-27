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
    <label for="nama_pegawai" class="block text-sm font-medium text-gray-700">Nama Pegawai <span class="text-red-500">*</span></label>
    <input type="text" name="nama_pegawai" id="nama_pegawai" value="{{ old('nama_pegawai', $pegawai->nama_pegawai ?? '') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           required autocomplete="name">
</div>

<div class="mb-4">
    <label for="nip" class="block text-sm font-medium text-gray-700">NIP (Nomor Induk Pegawai)</label>
    <input type="text" name="nip" id="nip" value="{{ old('nip', $pegawai->nip ?? '') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           autocomplete="off">
</div>

<div class="mb-4">
    <label for="jabatan" class="block text-sm font-medium text-gray-700">Jabatan</label>
    <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $pegawai->jabatan ?? '') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           autocomplete="organization-title">
</div>

<div class="mb-4">
    <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
    <textarea name="alamat" id="alamat" rows="3"
              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('alamat', $pegawai->alamat ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label for="telepon" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
    <input type="tel" name="telepon" id="telepon" value="{{ old('telepon', $pegawai->telepon ?? '') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           autocomplete="tel">
</div>

<div class="mb-4">
    <label for="user_id" class="block text-sm font-medium text-gray-700">Tautkan ke Akun User Sistem (Opsional)</label>
    <select name="user_id" id="user_id"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        <option value="">-- Tidak Ditautkan --</option>

        @foreach ($users ?? [] as $user)
            <option value="{{ $user->id }}" {{ (old('user_id', $pegawai->user_id ?? '') == $user->id) ? 'selected' : '' }}>
                {{ $user->name }} ({{ $user->email }}) - Role: {{ isset($user->role) && isset($user->role->name) ? $user->role->name : 'N/A' }}
            </option>
        @endforeach

        @if(isset($pegawai) && $pegawai->user_id && !collect($users ?? [])->contains('id', $pegawai->user_id))
            <option value="{{ $pegawai->user_id }}" selected>
                {{ $pegawai->user->name }} ({{ $pegawai->user->email }}) - Role: {{ $pegawai->user->role ? $pegawai->user->role->name : 'N/A' }} (Saat ini terpilih)
            </option>
        @endif
        
    </select>
</div>


<div>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        {{ $tombol_submit ?? 'Simpan' }}
    </button>
    <a href="{{ route('admin.pegawai.index') }}" class="ml-2 inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
        Batal
    </a>
</div>