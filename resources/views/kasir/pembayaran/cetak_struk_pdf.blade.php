<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Struk Pembayaran - {{ $kunjungan->no_kunjungan }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; margin: 0; font-size: 10px; }
        .container { width: 100%; padding: 10px; }
        .header { text-align: center; margin-bottom: 15px; }
        .header h1 { margin: 0; font-size: 16px; }
        .header p { margin: 0; font-size: 9px; }
        .content table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .content th, .content td { border-bottom: 1px dashed #ccc; padding: 4px; text-align: left; }
        .content th.right, .content td.right { text-align: right; }
        .total-section td { border-top: 1px solid #000; font-weight: bold; }
        .footer { text-align: center; margin-top: 20px; font-size: 9px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $namaKlinik }}</h1>
            <p>Rokan Hilir, Riau</p>
            <p>Telepon: (+62) 82283682243</p>
            <hr style="border-top: 1px solid #000; margin-top: 5px; margin-bottom: 5px;">
        </div>

        <div class="info" style="margin-bottom: 10px;">
            No. Struk: {{ $pembayaran->no_tagihan }} <span style="float:right;">Tgl: {{ $pembayaran->tanggal_pembayaran_lunas ? $pembayaran->tanggal_pembayaran_lunas->format('d/m/Y H:i') : '-'}}</span><br>
            Pasien: {{ $kunjungan->pasien->nama_pasien }} ({{ $kunjungan->pasien->no_rm }}) <span style="float:right;">Kasir: {{ $pembayaran->kasir->nama_pegawai ?? Auth::user()->name }}</span><br>
            Dokter: {{ $kunjungan->dokter->nama_pegawai ?? '-' }}
        </div>

        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>Deskripsi</th>
                        <th class="right">Jumlah</th>
                        <th class="right">Harga Satuan</th>
                        <th class="right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @if($kunjungan->daftarTindakan->count() > 0)
                        <tr><td colspan="4" style="font-weight:bold; padding-top: 5px;">Tindakan Medis:</td></tr>
                        @foreach($kunjungan->daftarTindakan as $item)
                        <tr>
                            <td>{{ $item->tindakan->nama_tindakan }}</td>
                            <td class="right">{{ $item->jumlah }}x</td>
                            <td class="right">{{ number_format($item->harga_saat_transaksi, 0, ',', '.') }}</td>
                            <td class="right">{{ number_format($item->harga_saat_transaksi * $item->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    @endif
                    @if($kunjungan->daftarObat->count() > 0)
                        <tr><td colspan="4" style="font-weight:bold; padding-top: 5px;">Obat-obatan:</td></tr>
                        @foreach($kunjungan->daftarObat as $item)
                        <tr>
                            <td>{{ $item->obat->nama_obat }}</td>
                            <td class="right">{{ $item->jumlah_obat }} {{ $item->obat->satuan }}</td>
                            <td class="right">{{ number_format($item->harga_jual_saat_transaksi, 0, ',', '.') }}</td>
                            <td class="right">{{ number_format($item->harga_jual_saat_transaksi * $item->jumlah_obat, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    @endif
                     @if($pembayaran->biaya_tambahan > 0)
                        <tr>
                            <td>Biaya Tambahan: {{ $pembayaran->keterangan_biaya_tambahan ?? '' }}</td>
                            <td class="right">1</td>
                            <td class="right">{{ number_format($pembayaran->biaya_tambahan, 0, ',', '.') }}</td>
                            <td class="right">{{ number_format($pembayaran->biaya_tambahan, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <hr style="border-top: 1px solid #000; margin-top: 5px; margin-bottom: 5px;">
            <table style="width: 50%; float: right;">
                 <tr>
                    <td>Subtotal</td>
                    <td class="right">Rp {{ number_format($pembayaran->subtotal, 0, ',', '.') }}</td>
                </tr>
                @if($pembayaran->diskon_nominal > 0)
                <tr>
                    <td>Diskon</td>
                    <td class="right">Rp {{ number_format($pembayaran->diskon_nominal, 0, ',', '.') }}</td>
                </tr>
                @endif
                <tr class="total-section">
                    <td>Grand Total</td>
                    <td class="right">Rp {{ number_format($pembayaran->grand_total, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Bayar</td>
                    <td class="right">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Kembali</td>
                    <td class="right">Rp {{ number_format($pembayaran->kembalian, 0, ',', '.') }}</td>
                </tr>
            </table>
            <div style="clear:both;"></div>
        </div>

        <div class="footer">
            <p>Terima kasih atas kunjungan Anda. Semoga lekas sembuh!</p>
             @if($pembayaran->metode_pembayaran)
                <p style="font-size: 8px;">Metode Pembayaran: {{ $pembayaran->metode_pembayaran }}
                    @if($pembayaran->nomor_referensi_pembayaran)
                     ({{ $pembayaran->nomor_referensi_pembayaran }})
                    @endif
                </p>
            @endif
        </div>
    </div>
</body>
</html>