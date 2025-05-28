<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pasien: {{ $pasien->nama_pasien }} (No. RM: {{ $pasien->no_rm }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-black mb-4">Data Pasien</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-sm text-black">
                        <div><strong>No. Rekam Medis:</strong> {{ $pasien->no_rm }}</div>
                        <div><strong>Nama Lengkap:</strong> {{ $pasien->nama_pasien }}</div>
                        <div><strong>NIK:</strong> {{ $pasien->nik ?? '-' }}</div>
                        <div><strong>Tempat, Tgl Lahir:</strong> {{ $pasien->tempat_lahir ?? '-' }}, {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') : '-' }}</div>
                        <div><strong>Jenis Kelamin:</strong> {{ $pasien->jenis_kelamin }}</div>
                        <div><strong>Telepon:</strong> {{ $pasien->telepon ?? '-' }}</div>
                        <div class="md:col-span-2"><strong>Alamat Lengkap:</strong> {{ $pasien->alamat_lengkap }}</div>
                        <div><strong>Wilayah:</strong> {{ $pasien->wilayah->nama_wilayah ?? '-' }}</div>
                        <div><strong>Pekerjaan:</strong> {{ $pasien->pekerjaan ?? '-' }}</div>
                        <div><strong>Agama:</strong> {{ $pasien->agama ?? '-' }}</div>
                        <div><strong>Status Pernikahan:</strong> {{ $pasien->status_pernikahan ?? '-' }}</div>
                        <div><strong>Golongan Darah:</strong> {{ $pasien->golongan_darah ?? '-' }}</div>
                        <div class="md:col-span-2"><strong>Alergi Obat:</strong> {{ $pasien->alergi_obat ?? '-' }}</div>
                        <div><strong>Nama Penanggung Jawab:</strong> {{ $pasien->nama_penanggung_jawab ?? '-' }}</div>
                        <div><strong>Telepon Penanggung Jawab:</strong> {{ $pasien->telepon_penanggung_jawab ?? '-' }}</div>
                        <div><strong>Tanggal Terdaftar:</strong> {{ $pasien->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    {{-- <div class="mt-6">
                        <a href="{{ route('petugas.pasien.edit', $pasien->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-black font-bold py-2 px-4 rounded">
                            Edit Data Pasien
                        </a>
                    </div> --}}
                </div>
            </div>

            {{-- Riwayat Kunjungan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Kunjungan</h3>
                    @if ($riwayatKunjungan->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Kunjungan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Kunjungan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keluhan Utama</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($riwayatKunjungan as $kunjungan)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $kunjungan->no_kunjungan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $kunjungan->tanggal_kunjungan->format('d M Y, H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $kunjungan->jenis_kunjungan }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ Str::limit($kunjungan->keluhan_utama, 50) ?: '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $kunjungan->dokter->nama_pegawai ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($kunjungan->status_kunjungan == 'Menunggu Antrian Poli') bg-yellow-100 text-yellow-800
                                                    @elseif($kunjungan->status_kunjungan == 'Menunggu Pemeriksaan' || $kunjungan->status_kunjungan == 'Sedang Diperiksa') bg-blue-100 text-blue-800
                                                    @elseif($kunjungan->status_kunjungan == 'Menunggu Pembayaran') bg-orange-100 text-orange-800
                                                    @elseif($kunjungan->status_kunjungan == 'Selesai') bg-green-100 text-green-800
                                                    @elseif($kunjungan->status_kunjungan == 'Batal') bg-red-100 text-red-800
                                                    @else bg-gray-100 text-gray-800
                                                    @endif">
                                                    {{ $kunjungan->status_kunjungan }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                @if(in_array($kunjungan->status_kunjungan, ['Menunggu Pemeriksaan', 'Sedang Diperiksa', 'Menunggu Pembayaran', 'Selesai']))
                                                    <a href="{{ route('dokter.kunjungan.pemeriksaan.form', $kunjungan->id) }}" class="text-indigo-600 hover:text-indigo-900 text-xs">Lihat/Lanjut Pemeriksaan</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $riwayatKunjungan->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">Belum ada riwayat kunjungan untuk pasien ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>