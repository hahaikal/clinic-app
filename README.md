# Clinic-app (Sistem Informasi Klinik)

Sistem Informasi Klinik "Clinic-app" adalah aplikasi web yang dirancang untuk membantu mengelola operasional klinik, mulai dari pendaftaran pasien, pemeriksaan medis, manajemen data master, hingga proses pembayaran dan pelaporan. Aplikasi ini dibangun menggunakan framework Laravel dengan antarmuka pengguna yang modern.

## Fitur Utama

### Untuk Admin:
- Manajemen Pengguna Sistem (User & Role)
- Manajemen Data Pegawai (Dokter, Petugas, Kasir)
- Manajemen Data Master Wilayah
- Manajemen Data Master Tindakan Medis
- Manajemen Data Master Obat
- Melihat Laporan Klinik (Grafik Kunjungan Harian/Bulanan, Tindakan & Obat Terbanyak)

### Untuk Petugas Pendaftaran:
- Pendaftaran Kunjungan untuk Pasien Baru & Lama
- Melihat Detail Pasien dan Riwayat Kunjungan

### Untuk Dokter:
- Melihat Daftar Kunjungan Pasien yang perlu dilayani
- Melakukan Pemeriksaan Pasien
- Menambahkan Tindakan Medis ke dalam Kunjungan
- Membuat dan Menambahkan Resep Obat
- Menyelesaikan Proses Pemeriksaan
- Melihat Detail Pasien dan Riwayat Kunjungan

### Untuk Kasir:
- Melihat Daftar Tagihan Pasien yang Menunggu Pembayaran
- Memproses Pembayaran Tagihan
- Mencetak Struk Pembayaran

### Fitur Umum:
- Autentikasi Pengguna
- Manajemen Profil Pengguna
- Halaman Landing Page yang Informatif
- Dashboard Dinamis Berdasarkan Peran Pengguna
- Navigasi Aplikasi yang Disederhanakan

## Teknologi yang Digunakan

- **Backend:** Laravel Framework 12.x
- **Frontend:**
    - Blade Templating Engine
    - Tailwind CSS
    - DaisyUI (Plugin Tailwind CSS)
    - Alpine.js
- **Database:** PostgreSQL
- **PDF Generation:** `barryvdh/laravel-dompdf`
- **Build Tool:** Vite

## Persyaratan Sistem

- PHP ^8.2
- Composer 2.x
- Node.js & NPM
- Database PostgreSQL

## Instalasi & Setup

1.  Clone repository ini:
    \`\`\`bash
    git clone https://github.com/hahaikal/clinic-app clinic-app
    cd clinic-app
    \`\`\`
2.  Install dependensi PHP:
    \`\`\`bash      
    composer install
    \`\`\`
3.  Salin file environment:
    \`\`\`bash
    cp .env.example .env
    \`\`\`
4.  Generate application key:
    \`\`\`bash
    php artisan key:generate
    \`\`\`
5.  Konfigurasi database Anda di file `.env`:
    \`\`\`env
    \`\`\`
6.  Jalankan migrasi dan seeder:
    \`\`\`bash
    php artisan migrate --seed
    \`\`\`
7.  Install dependensi JavaScript:
    \`\`\`bash
    npm install
    \`\`\`
8.  Build aset frontend:
    \`\`\`bash
    npm run build
    \`\`\`

## Menjalankan Aplikasi

- **Untuk Development (menggunakan server bawaan Laravel dan Vite):**
  Jalankan perintah berikut dari root direktori proyek:
  \`\`\`bash
  composer run dev
  \`\`\`
  Aplikasi akan tersedia di `http://localhost:8000`.

## Kredensial Login Default

Setelah menjalankan `php artisan migrate --seed`, Anda dapat login menggunakan akun admin default:
- **Email:** `admin@klinik.com`
- **Password:** `admin123`

## Struktur Database
- **users**: Menyimpan data pengguna sistem (login).
- **roles**: Menyimpan daftar peran pengguna (Admin, Petugas, Dokter, Kasir).
- **pegawai**: Menyimpan data detail pegawai/staff klinik, tertaut ke tabel `users`.
- **wilayahs**: Menyimpan data master wilayah administratif.
- **pasien**: Menyimpan data rekam medis pasien.
- **kunjungan**: Mencatat setiap kunjungan pasien ke klinik.
- **tindakan**: Menyimpan data master tindakan medis beserta tarifnya.
- **obat**: Menyimpan data master obat beserta stok dan harga.
- **kunjungan_tindakan**: Tabel pivot untuk mencatat tindakan yang diberikan pada suatu kunjungan.
- **kunjungan_obat**: Tabel pivot untuk mencatat obat yang diresepkan pada suatu kunjungan.
- **pembayaran**: Mencatat detail tagihan dan status pembayaran untuk setiap kunjungan.


## Alur Kerja Pengunaan Aplikasi
- **Login (Admin)**: 
    - *Membuat Akun User lain (Petugas Pendaftaran, Dokter, Kasir) di halaman Manajemen User*
    - *Mengelola Manajemen Pegawai dengan Menautkan ke Akun User*
    - *Mengelola Data Master Wilayah Administratif*
    - *Mengelola Data Master Tindakan Medis*
    - *Mengelola Data Master Obat*

- **Login (Petugas Pendaftaran)**:
    - *Mengelola Pendaftaran Pasien*

- **Login (Dokter)**:
    - *Menindaklanjuti Kunjungan Pasien/Melakukan Pemeriksaan Pasien*
    - *Tambah Tindakan Medis*
    - *Tambah Obat*
    - *SOAP*
    - *Selesaikan Pemeriksaan*

- **Login (Kasir)**: 
    - *Melakukan Proses Pembayaran*
    - *Mencetak Struk Pembayaran*