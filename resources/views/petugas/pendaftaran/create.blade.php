<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pendaftaran Pasien Baru & Kunjungan Awal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">
                            <strong class="font-bold">Oops! Ada beberapa masalah dengan input Anda:</strong>
                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded">
                            <strong class="font-bold"> {{ session('success') }} </strong>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('petugas.pendaftaran.pasien.store') }}">
                        @csrf

                        {{-- DATA PASIEN --}}
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Data Pasien</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="nama_pasien" class="block text-sm font-medium text-gray-700">Nama Pasien <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_pasien" id="nama_pasien" value="{{ old('nama_pasien') }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                                <input type="text" name="nik" id="nik" value="{{ old('nik') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin <span class="text-red-500">*</span></label>
                                <select name="jenis_kelamin" id="jenis_kelamin" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div>
                                <label for="telepon" class="block text-sm font-medium text-gray-700">Telepon</label>
                                <input type="tel" name="telepon" id="telepon" value="{{ old('telepon') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                        <div class="mb-6">
                            <label for="alamat_lengkap" class="block text-sm font-medium text-gray-700">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="alamat_lengkap" id="alamat_lengkap" rows="3" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('alamat_lengkap') }}</textarea>
                        </div>

                        {{-- DATA KUNJUNGAN AWAL --}}
                        <h3 class="text-lg font-medium text-gray-900 mb-4 mt-8 border-t pt-4">Data Kunjungan Awal</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="jenis_kunjungan" class="block text-sm font-medium text-gray-700">Jenis Kunjungan <span class="text-red-500">*</span></label>
                                <select name="jenis_kunjungan" id="jenis_kunjungan" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="">-- Pilih Jenis Kunjungan --</option>
                                    @foreach ($jenisKunjunganOptions as $opsi)
                                        <option value="{{ $opsi }}" {{ old('jenis_kunjungan') == $opsi ? 'selected' : '' }}>{{ $opsi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label for="keluhan_utama" class="block text-sm font-medium text-gray-700">Keluhan Utama</label>
                                <textarea name="keluhan_utama" id="keluhan_utama" rows="3" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('keluhan_utama') }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-black font-bold py-2 px-4 rounded">
                                Daftarkan Pasien & Kunjungan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>