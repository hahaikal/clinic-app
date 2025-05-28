<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Proses Pembayaran - No. Kunjungan: {{ $kunjungan->no_kunjungan }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Pasien: {{ $kunjungan->pasien->nama_pasien }} (No. RM: {{ $kunjungan->pasien->no_rm }})</h3>
                    <p class="text-sm text-gray-600">Tgl Kunjungan: {{ $kunjungan->tanggal_kunjungan->format('d M Y, H:i') }} | Jenis: {{ $kunjungan->jenis_kunjungan }}</p>
                    <p class="text-sm text-gray-600">Dokter: {{ $kunjungan->dokter->nama_pegawai ?? '-' }}</p>
                </div>
            </div>

            {{-- Rincian Tagihan --}}
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Rincian Tagihan (No: {{ $pembayaran->no_tagihan }})</h3>
                    <div class="space-y-2 text-sm mb-4 text-gray-900">
                        @if($kunjungan->daftarTindakan->count() > 0)
                            <p class="font-medium">Tindakan Medis:</p>
                            <ul class="list-disc list-inside pl-4">
                                @foreach($kunjungan->daftarTindakan as $item)
                                <li>{{ $item->tindakan->nama_tindakan }} ({{ $item->jumlah }}x) - @ Rp {{ number_format($item->harga_saat_transaksi, 0, ',', '.') }} : <span class="float-right">Rp {{ number_format($item->harga_saat_transaksi * $item->jumlah, 0, ',', '.') }}</span></li>
                                @endforeach
                            </ul>
                            <div class="text-right font-semibold">Total Tindakan: Rp {{ number_format($pembayaran->total_biaya_tindakan, 0, ',', '.') }}</div>
                            <hr class="my-1">
                        @endif

                        @if($kunjungan->daftarObat->count() > 0)
                            <p class="font-medium">Obat-obatan:</p>
                            <ul class="list-disc list-inside pl-4">
                                @foreach($kunjungan->daftarObat as $item)
                                <li>{{ $item->obat->nama_obat }} ({{ $item->jumlah_obat }} {{ $item->obat->satuan }}) - @ Rp {{ number_format($item->harga_jual_saat_transaksi, 0, ',', '.') }} : <span class="float-right">Rp {{ number_format($item->harga_jual_saat_transaksi * $item->jumlah_obat, 0, ',', '.') }}</span></li>
                                @endforeach
                            </ul>
                            <div class="text-right font-semibold">Total Obat: Rp {{ number_format($pembayaran->total_biaya_obat, 0, ',', '.') }}</div>
                            <hr class="my-1">
                        @endif
                    </div>

                    {{-- Form Pembayaran --}}
                    <form method="POST" action="{{ route('kasir.tagihan.proses', $kunjungan->id) }}">
                        @csrf

                        <input type="hidden" name="pembayaran_id" value="{{ $pembayaran->id }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label for="biaya_tambahan" class="block text-sm font-medium text-gray-700">Biaya Tambahan (Rp)</label>
                                <input type="number" name="biaya_tambahan" id="biaya_tambahan" value="{{ old('biaya_tambahan', $pembayaran->biaya_tambahan ?? 0) }}" min="0" step="any" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 text-gray-700 rounded-md">
                            </div>
                            <div>
                                <label for="keterangan_biaya_tambahan" class="block text-sm font-medium text-gray-700">Ket. Biaya Tambahan</label>
                                <input type="text" name="keterangan_biaya_tambahan" id="keterangan_biaya_tambahan" value="{{ old('keterangan_biaya_tambahan', $pembayaran->keterangan_biaya_tambahan ?? '') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 text-gray-700 rounded-md">
                            </div>
                            <div>
                                <label for="diskon_nominal" class="block text-sm font-medium text-gray-700">Diskon Nominal (Rp)</label>
                                <input type="number" name="diskon_nominal" id="diskon_nominal" value="{{ old('diskon_nominal', $pembayaran->diskon_nominal ?? 0) }}" min="0" step="any" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 text-gray-700 rounded-md">
                            </div>
                        </div>
                        <hr class="my-3">

                        <div class="text-right mb-4 space-y-1 text-gray-700">
                            <p class="text-sm">Subtotal (Tindakan + Obat + Biaya Tambahan): <span class="font-semibold">Rp {{ number_format($pembayaran->subtotal, 0, ',', '.') }}</span></p>
                            <p class="text-sm">Total Diskon: <span class="font-semibold">- Rp {{ number_format($diskon_nominal_display ?? ($pembayaran->subtotal - $pembayaran->total_setelah_diskon), 0, ',', '.') }}</span></p>
                            <p class="text-lg font-bold">Grand Total: <span class="text-green-600">Rp {{ number_format($pembayaran->grand_total, 0, ',', '.') }}</span></p>
                        </div>

                        @if($pembayaran->status_pembayaran !== 'Lunas')
                            <h4 class="text-md font-semibold text-gray-900 mb-3 pt-3 border-t">Input Pembayaran</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                                <div>
                                    <label for="jumlah_bayar" class="block text-sm font-medium text-gray-700">Jumlah Bayar (Rp) <span class="text-red-500">*</span></label>
                                    <input type="number" name="jumlah_bayar" id="jumlah_bayar" value="{{ old('jumlah_bayar') }}" min="0" step="any" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 text-gray-700 rounded-md">
                                </div>
                                <div>
                                    <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700">Metode Pembayaran <span class="text-red-500">*</span></label>
                                    <select name="metode_pembayaran" id="metode_pembayaran" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 text-gray-700 rounded-md">
                                        <option value="">-- Pilih Metode --</option>
                                        @foreach($metodePembayaranOptions as $metode)
                                            <option value="{{ $metode }}" {{ old('metode_pembayaran') == $metode ? 'selected' : '' }}>{{ $metode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="nomor_referensi_pembayaran" class="block text-sm font-medium text-gray-700">No. Referensi (Kartu/Transaksi)</label>
                                    <input type="text" name="nomor_referensi_pembayaran" id="nomor_referensi_pembayaran" value="{{ old('nomor_referensi_pembayaran') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 text-gray-700 rounded-md">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="catatan_pembayaran" class="block text-sm font-medium text-gray-700">Catatan Pembayaran</label>
                                    <textarea name="catatan_pembayaran" id="catatan_pembayaran" rows="2" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 text-gray-700 rounded-md">{{ old('catatan_pembayaran') }}</textarea>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="bg-green-600 hover:bg-green-800 text-black font-bold py-2 px-4 rounded">
                                    Proses & Simpan Pembayaran
                                </button>
                            </div>
                        @else
                            <div class="p-4 bg-green-50 text-green-700 rounded-md">
                                <p class="font-semibold">Tagihan ini sudah LUNAS.</p>
                                <p class="text-sm">Dibayar pada: {{ $pembayaran->tanggal_pembayaran_lunas ? $pembayaran->tanggal_pembayaran_lunas->format('d M Y, H:i') : '-' }}</p>
                                <p class="text-sm">Metode: {{ $pembayaran->metode_pembayaran }}</p>
                                <p class="text-sm">Jumlah Bayar: Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                                <p class="text-sm">Kembalian: Rp {{ number_format($pembayaran->kembalian, 0, ',', '.') }}</p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>