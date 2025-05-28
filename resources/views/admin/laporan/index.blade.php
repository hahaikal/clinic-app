<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Laporan Klinik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6 bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex items-center space-x-3">
                        <label for="tipe_kunjungan_filter" class="text-sm font-medium text-gray-700 whitespace-nowrap">Laporan Kunjungan:</label>
                        <select name="tipe_kunjungan" id="tipe_kunjungan_filter" class="block w-auto pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="bulanan" {{ ($dataKunjungan['tipe'] ?? 'bulanan') == 'bulanan' ? 'selected' : '' }}>
                                Bulanan (12 Bulan Terakhir)
                            </option>
                            <option value="harian" {{ ($dataKunjungan['tipe'] ?? 'bulanan') == 'harian' ? 'selected' : '' }}>
                                Harian (30 Hari Terakhir)
                            </option>
                        </select>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-black bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Tampilkan Kunjungan
                        </button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        @if (!empty($dataKunjungan['labels']) && !empty($dataKunjungan['data']))
                            <h3 class="text-lg font-semibold text-gray-700 mb-3">{{ $dataKunjungan['labelGrafik'] }}</h3>
                            <canvas id="kunjunganChartDashboard" height="150"></canvas>
                        @else
                            <h3 class="text-lg font-semibold text-gray-700 mb-3">Laporan Kunjungan</h3>
                            <p class="text-gray-500">Data kunjungan tidak cukup untuk ditampilkan.</p>
                        @endif
                    </div>
                </div>

                {{-- Laporan Tindakan Terbanyak --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        @if (!empty($dataTindakan['labels']) && !empty($dataTindakan['data']))
                            <h3 class="text-lg font-semibold text-gray-700 mb-3">{{ $dataTindakan['labelGrafik'] }}</h3>
                            <canvas id="tindakanChartDashboard" height="150"></canvas>
                        @else
                            <h3 class="text-lg font-semibold text-gray-700 mb-3">Laporan Tindakan Terbanyak</h3>
                            <p class="text-gray-500">Data tindakan tidak cukup untuk ditampilkan.</p>
                        @endif
                    </div>
                </div>

                {{-- Laporan Obat Terbanyak --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg lg:col-span-2">
                    <div class="p-6">
                        @if (!empty($dataObat['labels']) && !empty($dataObat['data']))
                            <h3 class="text-lg font-semibold text-gray-700 mb-3">{{ $dataObat['labelGrafik'] }}</h3>
                            <canvas id="obatChartDashboard" height="150"></canvas>
                        @else
                             <h3 class="text-lg font-semibold text-gray-700 mb-3">Laporan Obat Terbanyak</h3>
                            <p class="text-gray-500">Data peresepan obat tidak cukup untuk ditampilkan.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dataKunjungan = @json($dataKunjungan);
            const dataTindakan = @json($dataTindakan);
            const dataObat = @json($dataObat);

            const ctxKunjungan = document.getElementById('kunjunganChartDashboard');
            if (ctxKunjungan && dataKunjungan.labels && dataKunjungan.labels.length > 0) {
                new Chart(ctxKunjungan.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: dataKunjungan.labels,
                        datasets: [{
                            label: dataKunjungan.labelGrafik,
                            data: dataKunjungan.data,
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: { y: { beginAtZero: true, ticks: { stepSize: 1, callback: function(value) {if (value % 1 === 0) {return value;}}} } },
                        plugins: { legend: { display: false }, title: { display: false } }
                    }
                });
            }

            const ctxTindakan = document.getElementById('tindakanChartDashboard');
            if (ctxTindakan && dataTindakan.labels && dataTindakan.labels.length > 0) {
                new Chart(ctxTindakan.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: dataTindakan.labels,
                        datasets: [{
                            label: dataTindakan.labelGrafik,
                            data: dataTindakan.data,
                            backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)',],
                            borderColor: ['rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)',],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: { x: { beginAtZero: true, ticks: { stepSize: 1, callback: function(value) {if (Number.isInteger(value)) {return value;}}} } },
                        plugins: { legend: { display: false }, title: { display: false } }
                    }
                });
            }

            const ctxObat = document.getElementById('obatChartDashboard');
            if (ctxObat && dataObat.labels && dataObat.labels.length > 0) {
                new Chart(ctxObat.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: dataObat.labels,
                        datasets: [{
                            label: dataObat.labelGrafik,
                            data: dataObat.data,
                            backgroundColor: ['rgba(75, 192, 192, 0.5)', 'rgba(255, 159, 64, 0.5)',],
                            borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 159, 64, 1)',],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: { x: { beginAtZero: true, ticks: { stepSize: 1, callback: function(value) {if (Number.isInteger(value)) {return value;}}} } },
                        plugins: { legend: { display: false }, title: { display: false } }
                    }
                });
            }
        });
    </script>
</x-app-layout>