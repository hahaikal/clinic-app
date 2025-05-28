<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-black-200 leading-tight">
                {{ __('Dashboard') }} - Selamat Datang, {{ $user->name }}
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 ml-2">
                    {{ $roleName }}
                </span>
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ now()->format('l, d F Y') }}
            </p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg border border-red-200 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($roleName === 'Admin')
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-5 mb-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Dashboard Administrator
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                Pantau dan kelola seluruh aktivitas klinik dari satu tempat
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                            <div class="stats bg-white dark:bg-gray-700 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="stat">
                                    <div class="stat-figure text-primary">
                                        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="stat-title text-gray-600 dark:text-gray-400">Total Pasien</div>
                                    <div class="stat-value text-primary">{{ number_format($data['totalPasien'] ?? 0) }}</div>
                                    <div class="stat-desc">Terdaftar dalam sistem</div>
                                </div>
                            </div>

                            <div class="stats bg-white dark:bg-gray-700 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="stat">
                                    <div class="stat-figure text-secondary">
                                        <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="stat-title text-gray-600 dark:text-gray-400">Kunjungan Hari Ini</div>
                                    <div class="stat-value text-secondary">{{ number_format($data['kunjunganHariIni'] ?? 0) }}</div>
                                    <div class="stat-desc">Pasien yang berkunjung</div>
                                </div>
                            </div>

                            <div class="stats bg-white dark:bg-gray-700 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="stat">
                                    <div class="stat-figure text-accent">
                                        <div class="w-12 h-12 rounded-full bg-accent/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="stat-title text-gray-600 dark:text-gray-400">Total Pengguna</div>
                                    <div class="stat-value text-accent">{{ number_format($data['totalUser'] ?? 0) }}</div>
                                    <div class="stat-desc">Staff & Administrator</div>
                                </div>
                            </div>

                            <div class="stats bg-white dark:bg-gray-700 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="stat">
                                    <div class="stat-figure text-success">
                                        <div class="w-12 h-12 rounded-full bg-success/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="stat-title text-gray-600 dark:text-gray-400">Pendapatan Hari Ini</div>
                                    <div class="stat-value text-success">Rp {{ number_format($data['pendapatanHariIni'] ?? 0, 0, ',', '.') }}</div>
                                    <div class="stat-desc">Total pemasukan</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h4 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Menu Cepat</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 group">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-300 transition-colors">Manajemen User</h5>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola pengguna sistem</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.pegawai.index') }}" class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 group">
                                    <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-300 transition-colors">Manajemen Pegawai</h5>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data pegawai</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.wilayah.index') }}" class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 group">
                                    <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-300 transition-colors">Manajemen Wilayah</h5>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data wilayah</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.tindakan.index') }}" class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 group">
                                    <div class="w-10 h-10 rounded-full bg-yellow-100 dark:bg-yellow-900 flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-900 dark:text-white group-hover:text-yellow-600 dark:group-hover:text-yellow-300 transition-colors">Manajemen Tindakan</h5>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data tindakan medis</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.obat.index') }}" class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 group">
                                    <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-red-600 dark:text-red-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-900 dark:text-white group-hover:text-red-600 dark:group-hover:text-red-300 transition-colors">Manajemen Obat</h5>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola inventaris obat</p>
                                    </div>
                                </a>

                                <a href="{{ route('admin.laporan.index') }}" class="flex items-center p-4 bg-white dark:bg-gray-700 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300 group">
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-300 transition-colors">Laporan Klinik</h5>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Lihat laporan & statistik</p>
                                    </div>
                                </a>
                            </div>
                        </div>

                    @elseif ($roleName === 'Petugas Pendaftaran')
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-5 mb-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Dashboard Petugas Pendaftaran
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                Kelola pendaftaran dan antrian pasien
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="stats bg-white dark:bg-gray-700 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="stat">
                                    <div class="stat-figure text-primary">
                                        <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="stat-title text-gray-600 dark:text-gray-400">Pasien Baru Hari Ini</div>
                                    <div class="stat-value text-primary">{{ number_format($data['pasienBaruHariIni'] ?? 0) }}</div>
                                    <div class="stat-desc">Pendaftaran baru</div>
                                </div>
                            </div>

                            <div class="stats bg-white dark:bg-gray-700 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="stat">
                                    <div class="stat-figure text-secondary">
                                        <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="stat-title text-gray-600 dark:text-gray-400">Antrian Poli Hari Ini</div>
                                    <div class="stat-value text-secondary">{{ number_format($data['antrianPoli'] ?? 0) }}</div>
                                    <div class="stat-desc">Menunggu pemeriksaan</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center">
                            <a href="{{ route('petugas.pendaftaran.pasien.create') }}" class="btn btn-primary btn-lg gap-2">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                                Pendaftaran Pasien Baru
                            </a>
                        </div>

                    @elseif ($roleName === 'Dokter')
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-5 mb-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Dashboard Dokter
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                Kelola pemeriksaan dan riwayat pasien
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="stats bg-white dark:bg-gray-700 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="stat">
                                    <div class="stat-figure text-warning">
                                        <div class="w-12 h-12 rounded-full bg-warning/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="stat-title text-gray-600 dark:text-gray-400">Pasien Menunggu</div>
                                    <div class="stat-value text-warning">{{ number_format($data['menungguPemeriksaan'] ?? 0) }}</div>
                                    <div class="stat-desc">Perlu pemeriksaan</div>
                                </div>
                            </div>

                            <div class="stats bg-white dark:bg-gray-700 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="stat">
                                    <div class="stat-figure text-success">
                                        <div class="w-12 h-12 rounded-full bg-success/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="stat-title text-gray-600 dark:text-gray-400">Pemeriksaan Selesai</div>
                                    <div class="stat-value text-success">{{ number_format($data['pemeriksaanSelesaiHariIni'] ?? 0) }}</div>
                                    <div class="stat-desc">Hari ini</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center">
                            <a href="{{ route('dokter.kunjungan.index') }}" class="btn btn-primary btn-lg gap-2">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                Lihat Daftar Kunjungan
                            </a>
                        </div>

                    @elseif ($roleName === 'Kasir')
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-5 mb-6">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                Dashboard Kasir
                            </h3>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                Kelola pembayaran dan tagihan pasien
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="stats bg-white dark:bg-gray-700 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="stat">
                                    <div class="stat-figure text-warning">
                                        <div class="w-12 h-12 rounded-full bg-warning/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-warning" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="stat-title text-gray-600 dark:text-gray-400">Tagihan Pending</div>
                                    <div class="stat-value text-warning">{{ number_format($data['tagihanMenungguPembayaran'] ?? 0) }}</div>
                                    <div class="stat-desc">Menunggu pembayaran</div>
                                </div>
                            </div>

                            <div class="stats bg-white dark:bg-gray-700 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="stat">
                                    <div class="stat-figure text-success">
                                        <div class="w-12 h-12 rounded-full bg-success/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-success" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="stat-title text-gray-600 dark:text-gray-400">Transaksi Lunas</div>
                                    <div class="stat-value text-success">{{ number_format($data['transaksiLunasHariIni'] ?? 0) }}</div>
                                    <div class="stat-desc">Hari ini</div>
                                </div>
                            </div>

                            <div class="stats bg-white dark:bg-gray-700 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="stat">
                                    <div class="stat-figure text-info">
                                        <div class="w-12 h-12 rounded-full bg-info/10 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="stat-title text-gray-600 dark:text-gray-400">Total Pembayaran</div>
                                    <div class="stat-value text-info">Rp {{ number_format($data['totalPembayaranHariIni'] ?? 0, 0, ',', '.') }}</div>
                                    <div class="stat-desc">Hari ini</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-center">
                            <a href="{{ route('kasir.tagihan.index') }}" class="btn btn-primary btn-lg gap-2">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Lihat Daftar Tagihan
                            </a>
                        </div>

                    @else
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-xl font-medium text-gray-900 dark:text-white">{{ __("You're logged in!") }}</p>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">Silakan hubungi administrator untuk mengatur akses Anda.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>