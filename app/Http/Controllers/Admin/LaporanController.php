<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\KunjunganTindakan;
use App\Models\KunjunganObat; 

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tipeKunjungan = $request->input('tipe_kunjungan', 'bulanan');
        $dataKunjungan = $this->getDataLaporanKunjungan($tipeKunjungan);

        $dataTindakan = $this->getDataLaporanTindakanTerbanyak();

        $dataObat = $this->getDataLaporanObatTerbanyak();

        return view('admin.laporan.index', compact(
            'dataKunjungan',
            'dataTindakan',
            'dataObat'
        ));
    }

    private function getDataLaporanKunjungan($tipe = 'bulanan')
    {
        $labels = [];
        $data = [];
        $labelGrafik = '';

        if ($tipe == 'harian') {
            $endDate = Carbon::now();
            $startDate = Carbon::now()->subDays(29);
            $kunjungans = Kunjungan::select(
                                DB::raw('DATE(tanggal_kunjungan) as tanggal'),
                                DB::raw('COUNT(*) as jumlah')
                            )
                            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                            ->groupBy('tanggal')
                            ->orderBy('tanggal', 'asc')
                            ->get();
            $currentDate = $startDate->copy();
            while ($currentDate <= $endDate) {
                $labels[] = $currentDate->format('d M');
                $kunjunganPadaHariIni = $kunjungans->firstWhere('tanggal', $currentDate->format('Y-m-d'));
                $data[] = $kunjunganPadaHariIni ? $kunjunganPadaHariIni->jumlah : 0;
                $currentDate->addDay();
            }
            $labelGrafik = 'Jumlah Kunjungan Harian (30 Hari Terakhir)';
        } else {
            $endDate = Carbon::now()->endOfMonth();
            $startDate = Carbon::now()->subMonths(11)->startOfMonth();
            $kunjungans = Kunjungan::select(
                                DB::raw("TO_CHAR(tanggal_kunjungan, 'YYYY-MM') as bulan_tahun"),
                                DB::raw('COUNT(*) as jumlah')
                            )
                            ->whereBetween('tanggal_kunjungan', [$startDate, $endDate])
                            ->groupBy('bulan_tahun')
                            ->orderBy('bulan_tahun', 'asc')
                            ->get();
            $currentMonth = $startDate->copy();
            while ($currentMonth <= $endDate) {
                $labels[] = $currentMonth->format('M Y');
                $kunjunganPadaBulanIni = $kunjungans->firstWhere('bulan_tahun', $currentMonth->format('Y-m'));
                $data[] = $kunjunganPadaBulanIni ? $kunjunganPadaBulanIni->jumlah : 0;
                $currentMonth->addMonth();
            }
            $labelGrafik = 'Jumlah Kunjungan Bulanan (12 Bulan Terakhir)';
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'labelGrafik' => $labelGrafik,
            'tipe' => $tipe,
        ];
    }

    private function getDataLaporanTindakanTerbanyak()
    {
        $topTindakans = KunjunganTindakan::select(
                            'tindakan_id',
                            DB::raw('SUM(jumlah) as total_jumlah_dilakukan')
                        )
                        ->with('tindakan')
                        ->groupBy('tindakan_id')
                        ->orderBy('total_jumlah_dilakukan', 'desc')
                        ->take(10)
                        ->get();
        $labels = [];
        $data = [];
        foreach ($topTindakans as $item) {
            $labels[] = $item->tindakan ? $item->tindakan->nama_tindakan : 'Tindakan Tidak Ditemukan';
            $data[] = $item->total_jumlah_dilakukan;
        }
        return [
            'labels' => $labels,
            'data' => $data,
            'labelGrafik' => 'Top 10 Tindakan Medis Terbanyak Dilakukan',
        ];
    }

    private function getDataLaporanObatTerbanyak()
    {
        $topObats = KunjunganObat::select(
                            'obat_id',
                            DB::raw('SUM(jumlah_obat) as total_jumlah_diresepkan')
                        )
                        ->with('obat')
                        ->groupBy('obat_id')
                        ->orderBy('total_jumlah_diresepkan', 'desc')
                        ->take(10)
                        ->get();
        $labels = [];
        $data = [];
        foreach ($topObats as $item) {
            $labels[] = $item->obat ? $item->obat->nama_obat . ' (' . $item->obat->satuan . ')' : 'Obat Tidak Ditemukan';
            $data[] = $item->total_jumlah_diresepkan;
        }
        return [
            'labels' => $labels,
            'data' => $data,
            'labelGrafik' => 'Top 10 Obat Paling Sering Diresepkan (Jumlah Unit)',
        ];
    }
}