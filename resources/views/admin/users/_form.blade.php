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
    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
    <input type="text" name="name" id="name" value="{{ old('name', $user->name ?? '') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           required autocomplete="name">
</div>

<div class="mb-4">
    <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email <span class="text-red-500">*</span></label>
    <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}"
           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
           required autocomplete="email">
</div>

@if(!isset($user))
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
        <input type="password" name="password" id="password"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
               required autocomplete="new-password">
    </div>

    <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password <span class="text-red-500">*</span></label>
        <input type="password" name="password_confirmation" id="password_confirmation"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
               required autocomplete="new-password">
    </div>
@else
    {{-- Info untuk edit password --}}
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru (Opsional)</label>
        <input type="password" name="password" id="password"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
               autocomplete="new-password">
        <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password.</p>
    </div>
     <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
        <input type="password" name="password_confirmation" id="password_confirmation"
               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
               autocomplete="new-password">
    </div>
@endif

<div class="mb-4">
    <label for="role_id" class="block text-sm font-medium text-gray-700">Role <span class="text-red-500">*</span></label>
    <select name="role_id" id="role_id"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            required>
        <option value="">-- Pilih Role --</option>
        @foreach ($roles ?? [] as $role)
            @if(is_object($role))
                <option value="{{ $role->id }}" {{ (old('role_id', $user->role_id ?? '') == $role->id) ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endif
        @endforeach
    </select>
</div>

<div>
    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
        {{ $tombol_submit ?? 'Simpan' }}
    </button>
    <a href="{{ route('admin.users.index') }}" class="ml-2 inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">
        Batal
    </a>
</div>