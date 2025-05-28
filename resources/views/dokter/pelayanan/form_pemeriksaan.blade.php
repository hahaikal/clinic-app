<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pemeriksaan Pasien: {{ $kunjungan->pasien->nama_pasien ?? 'N/A' }} (No. RM: {{ $kunjungan->pasien->no_rm ?? 'N/A' }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                    <strong class="font-bold">Oops! Ada beberapa masalah:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Informasi Kunjungan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div><strong>No. Kunjungan:</strong> {{ $kunjungan->no_kunjungan }}</div>
                        <div><strong>Tgl Kunjungan:</strong> {{ $kunjungan->tanggal_kunjungan->format('d M Y, H:i') }}</div>
                        <div><strong>Jenis Kunjungan:</strong> {{ $kunjungan->jenis_kunjungan }}</div>
                        <div><strong>Status:</strong> <span class="font-semibold">{{ $kunjungan->status_kunjungan }}</span></div>
                        <div class="md:col-span-2"><strong>Keluhan Utama:</strong> {{ $kunjungan->keluhan_utama ?: '-' }}</div>
                        <div><strong>Dokter:</strong> {{ $kunjungan->dokter->nama_pegawai ?? (Auth::user()->pegawai ? Auth::user()->pegawai->nama_pegawai : 'Belum Ditentukan') }}</div>
                    </div>
                    <hr class="my-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Informasi Pasien</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div><strong>No. RM:</strong> {{ $kunjungan->pasien->no_rm ?? 'N/A' }}</div>
                        <div><strong>Nama:</strong> {{ $kunjungan->pasien->nama_pasien ?? 'N/A' }}</div>
                        <div><strong>NIK:</strong> {{ $kunjungan->pasien->nik ?? '-' }}</div>
                        <div><strong>Tgl Lahir:</strong> {{ $kunjungan->pasien->tanggal_lahir ? Carbon\Carbon::parse($kunjungan->pasien->tanggal_lahir)->format('d M Y') : '-' }} (Usia: {{ $kunjungan->pasien->tanggal_lahir ? Carbon\Carbon::parse($kunjungan->pasien->tanggal_lahir)->age : '-' }} thn)</div>
                        <div><strong>Jenis Kelamin:</strong> {{ $kunjungan->pasien->jenis_kelamin ?? '-' }}</div>
                        <div><strong>Telepon:</strong> {{ $kunjungan->pasien->telepon ?? '-' }}</div>
                        <div class="md:col-span-3"><strong>Alamat:</strong> {{ $kunjungan->pasien->alamat_lengkap ?? '-' }}</div>
                        <div class="md:col-span-3"><strong>Alergi Obat:</strong> {{ $kunjungan->pasien->alergi_obat ?: '-' }}</div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('dokter.kunjungan.pemeriksaan.selesai', $kunjungan->id) }} " onsubmit="return confirm('Apakah Anda yakin ingin menyelesaikan pemeriksaan untuk kunjungan ini? Pastikan semua data tindakan dan obat sudah final.');" > 
                <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Pemeriksaan & Diagnosa Awal (SOAP)</h3>
                        @csrf

                        <div class="mb-4">
                            <label for="anamnesis" class="block text-sm font-medium text-gray-700">Anamnesis (Subjective & Objective)</label>
                            <textarea name="anamnesis" id="anamnesis" rows="4" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('anamnesis', $kunjungan->anamnesis) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div>
                                <label for="tinggi_badan_cm" class="block text-sm font-medium text-gray-700">Tinggi Badan (cm)</label>
                                <input type="number" name="tinggi_badan_cm" id="tinggi_badan_cm" value="{{ old('tinggi_badan_cm', $kunjungan->tinggi_badan_cm) }}" min="0" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Tinggi (cm)">
                            </div>
                            <div>
                                <label for="berat_badan_kg" class="block text-sm font-medium text-gray-700">Berat Badan (kg)</label>
                                <input type="number" name="berat_badan_kg" id="berat_badan_kg" value="{{ old('berat_badan_kg', $kunjungan->berat_badan_kg) }}" min="0" step="0.1" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Berat (kg)">
                            </div>
                            <div>
                                <label for="suhu_badan_celsius" class="block text-sm font-medium text-gray-700">Suhu Badan (°C)</label>
                                <input type="number" name="suhu_badan_celsius" id="suhu_badan_celsius" value="{{ old('suhu_badan_celsius', $kunjungan->suhu_badan_celsius) }}" min="0" step="0.1" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Suhu (°C)">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div>
                                <label for="sistole_mmhg" class="block text-sm font-medium text-gray-700">Sistole (mmHg)</label>
                                <input type="number" name="sistole_mmhg" id="sistole_mmhg" value="{{ old('sistole_mmhg', $kunjungan->sistole_mmhg) }}" min="0" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Sistole (mmHg)">
                            </div>
                            <div>
                                <label for="diastole_mmhg" class="block text-sm font-medium text-gray-700">Diastole (mmHg)</label>
                                <input type="number" name="diastole_mmhg" id="diastole_mmhg" value="{{ old('diastole_mmhg', $kunjungan->diastole_mmhg) }}" min="0" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Diastole (mmHg)">
                            </div>
                            <div>
                                <label for="frekuensi_nadi_per_menit" class="block text-sm font-medium text-gray-700">Frekuensi Nadi (per menit)</label>
                                <input type="number" name="frekuensi_nadi_per_menit" id="frekuensi_nadi_per_menit" value="{{ old('frekuensi_nadi_per_menit', $kunjungan->frekuensi_nadi_per_menit) }}" min="0" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Frekuensi Nadi">
                            </div>
                            <div>
                                <label for="frekuensi_nafas_per_menit" class="block text-sm font-medium text-gray-700">Frekuensi Nafas (per menit)</label>
                                <input type="number" name="frekuensi_nafas_per_menit" id="frekuensi_nafas_per_menit" value="{{ old('frekuensi_nafas_per_menit', $kunjungan->frekuensi_nafas_per_menit) }}" min="0" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Frekuensi Nafas">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-8 flex justify-end">
                    <input type="hidden" name="status_kunjungan_baru" value="Menunggu Pembayaran">

                    <button type="submit" class="bg-green-600 hover:bg-green-800 text-black font-bold py-2 px-4 rounded">
                        Selesaikan Pemeriksaan & Lanjut ke Pembayaran
                    </button>
                </div>
            </form>

            @include('dokter.pelayanan._form_tindakan', ['kunjungan' => $kunjungan, 'masterTindakans' => $masterTindakans])

            @include('dokter.pelayanan._form_obat', ['kunjungan' => $kunjungan, 'masterObats' => $masterObats])
            
        </div>
    </div>
</x-app-layout>