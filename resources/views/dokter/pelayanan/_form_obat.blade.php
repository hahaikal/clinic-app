<div class="bg-white shadow-sm sm:rounded-lg mb-6">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Resep Obat</h3>

        @if($kunjungan->daftarObat && $kunjungan->daftarObat->count() > 0)
            <div class="mb-4">
                <h4 class="text-md font-medium text-gray-800 mb-2">Daftar Obat Diresepkan:</h4>
                <ul class="list-disc list-inside space-y-1 text-sm">
                     @foreach($kunjungan->daftarObat as $itemObat)
                        <li class="flex justify-between items-center">
                            <span>
                                {{ $itemObat->obat->nama_obat ?? 'N/A' }} ({{ $itemObat->jumlah_obat }} {{ $itemObat->obat->satuan ?? '' }})
                                - Dosis: {{ $itemObat->dosis ?? '-' }}. Aturan: {{ $itemObat->aturan_pakai ?? '-' }}
                                - Rp {{ number_format($itemObat->harga_jual_saat_transaksi * $itemObat->jumlah_obat, 0, ',', '.') }}
                                @if($itemObat->catatan_resep) <em class="text-gray-500 text-xs">({{ $itemObat->catatan_resep }})</em> @endif
                            </span>
                            <form action="{{ route('dokter.kunjungan.obat.destroy', $itemObat->id) }}" method="POST" onsubmit="return confirm('Hapus obat ini dari resep?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Hapus</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
            
        @else
            <p class="text-sm text-gray-500 mb-4">Belum ada obat yang diresepkan.</p>
        @endif

        <form method="POST" action="{{ route('dokter.kunjungan.obat.store', $kunjungan->id) }}">
            @csrf
            <h4 class="text-md font-medium text-gray-800 mb-2">Tambah Resep Obat Baru:</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 text-gray-700">
                <div class="md:col-span-2">
                    <label for="obat_id" class="block text-sm font-medium text-gray-700">Pilih Obat <span class="text-red-500">*</span></label>
                    <select name="obat_id" id="obat_id" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <option value="">-- Pilih Obat --</option>
                        @foreach($masterObats as $masterObat)
                            <option value="{{ $masterObat->id }}" data-harga="{{ $masterObat->harga_jual }}" data-stok="{{ $masterObat->stok }}">
                                {{ $masterObat->nama_obat }} (Stok: {{ $masterObat->stok }} {{ $masterObat->satuan }}) - Rp {{ number_format($masterObat->harga_jual, 0, ',', '.') }}/{{$masterObat->satuan}}
                            </option>
                        @endforeach
                    </select>
                    <p id="stok_info_obat" class="mt-1 text-xs text-gray-500"></p>
                </div>
                <div>
                    <label for="jumlah_obat" class="block text-sm font-medium text-gray-700">Jumlah <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_obat" id="jumlah_obat" value="{{ old('jumlah_obat', 1) }}" min="1" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div>
                    <label for="dosis" class="block text-sm font-medium text-gray-700">Dosis</label>
                    <input type="text" name="dosis" id="dosis" value="{{ old('dosis') }}" placeholder="Mis: 3x1 tablet" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="md:col-span-2">
                    <label for="aturan_pakai" class="block text-sm font-medium text-gray-700">Aturan Pakai</label>
                    <input type="text" name="aturan_pakai" id="aturan_pakai" value="{{ old('aturan_pakai') }}" placeholder="Mis: Sesudah makan" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="md:col-span-2">
                    <label for="catatan_resep_form" class="block text-sm font-medium text-gray-700">Catatan Resep</label>
                    <input type="text" name="catatan_resep" id="catatan_resep_form" value="{{ old('catatan_resep') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
            </div>
            <input type="hidden" name="harga_jual_saat_transaksi" id="harga_jual_saat_transaksi_obat">

            <div class="mt-4">
                <button type="submit" class="bg-teal-500 hover:bg-teal-700 text-black font-bold py-2 px-4 rounded text-sm">
                    + Tambah Obat ke Resep
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const obatSelect = document.getElementById('obat_id');
    const hargaHiddenInputObat = document.getElementById('harga_jual_saat_transaksi_obat');
    const stokInfoObat = document.getElementById('stok_info_obat');

    if (obatSelect && hargaHiddenInputObat && stokInfoObat) {
        obatSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');
            const stok = selectedOption.getAttribute('data-stok');
            hargaHiddenInputObat.value = harga || '';
            if (stok !== null) {
                stokInfoObat.textContent = 'Info Stok Saat Ini: ' + stok;
                if (parseInt(stok) <= 0) {
                     stokInfoObat.classList.add('text-red-500');
                     stokInfoObat.classList.remove('text-gray-500');
                } else if (parseInt(stok) < 10) {
                     stokInfoObat.classList.add('text-yellow-500');
                     stokInfoObat.classList.remove('text-gray-500', 'text-red-500');
                }
                else {
                    stokInfoObat.classList.add('text-gray-500');
                    stokInfoObat.classList.remove('text-red-500', 'text-yellow-500');
                }
            } else {
                stokInfoObat.textContent = '';
            }
        });
        if(obatSelect.value) {
            obatSelect.dispatchEvent(new Event('change'));
        }
    }
});
</script>