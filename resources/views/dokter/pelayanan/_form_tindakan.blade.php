<div class="bg-white shadow-sm sm:rounded-lg mb-6">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan Medis</h3>

        @if($kunjungan->daftarTindakan && $kunjungan->daftarTindakan->count() > 0)
            <div class="mb-4">
                <h4 class="text-md font-medium text-gray-800 mb-2">Daftar Tindakan Diberikan:</h4>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach($kunjungan->daftarTindakan as $itemTindakan)
                        <li class="flex justify-between items-center">
                            <span>
                                {{ $itemTindakan->tindakan->nama_tindakan ?? 'N/A' }}
                                (Jml: {{ $itemTindakan->jumlah }})
                                - Rp {{ number_format($itemTindakan->harga_saat_transaksi * $itemTindakan->jumlah, 0, ',', '.') }}
                                @if($itemTindakan->catatan_tindakan) <em class="text-gray-500 text-xs">({{ $itemTindakan->catatan_tindakan }})</em> @endif
                            </span>
                            <form action="{{ route('dokter.kunjungan.tindakan.destroy', $itemTindakan->id) }}" method="POST" onsubmit="return confirm('Hapus tindakan ini dari kunjungan?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Hapus</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
            
        @else
            <p class="text-sm text-gray-500 mb-4">Belum ada tindakan yang ditambahkan.</p>
        @endif

        <form method="POST" action="{{ route('dokter.kunjungan.tindakan.store', $kunjungan->id) }}">
            @csrf
            <h4 class="text-md font-medium text-gray-800 mb-2">Tambah Tindakan Baru:</h4>
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
                <div class="md:col-span-3">
                    <label for="tindakan_id" class="block text-sm font-medium text-gray-700">Pilih Tindakan <span class="text-red-500">*</span></label>
                    <select name="tindakan_id" id="tindakan_id" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        <option value="">-- Pilih Tindakan --</option>
                        @foreach($masterTindakans as $masterTindakan)
                            <option value="{{ $masterTindakan->id }}" data-harga="{{ $masterTindakan->harga }}">
                                {{ $masterTindakan->nama_tindakan }} (Rp {{ number_format($masterTindakan->harga, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="jumlah_tindakan" class="block text-sm font-medium text-gray-700">Jumlah <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" id="jumlah_tindakan" value="{{ old('jumlah', 1) }}" min="1" required class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="md:col-span-2">
                    <label for="catatan_tindakan_form" class="block text-sm font-medium text-gray-700">Catatan</label>
                    <input type="text" name="catatan_tindakan" id="catatan_tindakan_form" value="{{ old('catatan_tindakan') }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
            </div>
            <input type="hidden" name="harga_saat_transaksi" id="harga_saat_transaksi_tindakan">

            <div class="mt-4">
                <button type="submit" class="bg-sky-500 hover:bg-sky-700 text-black font-bold py-2 px-4 rounded text-sm">
                    + Tambah Tindakan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tindakanSelect = document.getElementById('tindakan_id');
        const hargaHiddenInput = document.getElementById('harga_saat_transaksi_tindakan');

        if (tindakanSelect && hargaHiddenInput) {
            tindakanSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const harga = selectedOption.getAttribute('data-harga');
                hargaHiddenInput.value = harga || '';
            });
        }
    });
</script>