# BHP-Pandu Surabaya

Aplikasi portal permohonan layanan dan sistem administrasi digital Balai Harta Peninggalan (BHP) Surabaya — Direktorat Jenderal Administrasi Hukum Umum (Ditjen AHU), Kementerian Hukum dan HAM RI.

Aplikasi ini mencakup alur permohonan wasiat (terbuka & tertutup), Surat Keterangan Hak Waris (SKHW), pemantauan Service Level Agreement (SLA), hingga manajemen disposisi penugasan layanan oleh Kepala Seksi (KASI) ke fungsional Kurator Keperdataan (PIC).

---

## 🌟 Fitur Utama

- **Portal Pemohon**: Pendaftaran & verifikasi akun, pengajuan layanan wasiat & SKHW, pengunggahan berkas persyaratan, dan pemantauan status permohonan secara real-time.
- **Dashboard Verifikasi Petugas**: Pemeriksaan kelengkapan berkas fisik & digital, verifikasi data pemohon, dan pencatatan hasil telaah.
- **Dashboard KASI (Kepala Seksi)**:
  - **Disposisi Layanan**: Penugasan permohonan masuk ke petugas PIC/Kurator Keperdataan (Pertama, Muda, Madya).
  - **Pemantauan SLA**: Pemantauan batas waktu layanan (SLA Mendesak 13–14 hari & SLA Perhatian 8–12 hari) serta form tindak lanjut penyelesaian.
  - **History Layanan**: Rekapitulasi riwayat penyelesaian layanan lengkap dengan filter rentang tanggal (Mulai – Sampai) dan filter kategori layanan reaktif.

---

## 🛠️ Tech Stack

- **Framework**: [Laravel 13](https://laravel.com/) (PHP `>= 8.3`)
- **Frontend**: Blade Templating, [Tailwind CSS](https://tailwindcss.com/), [Alpine.js](https://alpinejs.dev/)
- **Bundler**: [Vite](https://vitejs.dev/)
- **Database**: MySQL `>= 8.0` / TiDB Cloud
- **Testing**: PHPUnit

---

## 🚀 Getting Started

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal:

### 1. Prasyarat Sistem
Pastikan perangkat Anda telah terpasang:
- PHP `>= 8.3` (dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `curl`)
- Composer `>= 2.x`
- Node.js `>= 18.x` & NPM
- MySQL Server / MariaDB

### 2. Clone Repository
```bash
git clone https://github.com/BHP-Surabaya/BHP-pandu.git
cd BHP-pandu
```

### 3. Install Dependensi
```bash
# Dependensi PHP
composer install

# Dependensi Frontend
npm install
```

### 4. Konfigurasi Environment (`.env`)
Salin file template `.env.example` ke `.env` lalu generate application key:
```bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env` dan sesuaikan koneksi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bhp_permohonan_wasiat
DB_USERNAME=root
DB_PASSWORD=
```
> **Catatan:** Buat database bernama `bhp_permohonan_wasiat` di MySQL/phpMyAdmin sebelum langkah berikutnya.

### 5. Migrasi & Seeder Database
Jalankan migrasi struktur tabel sekaligus data awal demo:
```bash
php artisan migrate --seed
```

### 6. Hubungkan Storage Link
Buat symbolic link storage agar berkas dokumen upload dapat diakses:
```bash
php artisan storage:link
```

### 7. Build Frontend Asset
Kompilasi asset Tailwind CSS & JS:
```bash
npm run build
```

### 8. Jalankan Aplikasi
Jalankan development server Laravel:
```bash
php artisan serve
```
Aplikasi dapat diakses melalui browser di: [http://localhost:8000](http://localhost:8000)

> **Tips:** Anda juga dapat menjalankan server Laravel dan Vite secara bersamaan menggunakan:
> ```bash
> composer run dev
> ```

---

## 🧪 Menjalankan Pengujian (Testing)

Jalankan test suite menggunakan PHPUnit:
```bash
# Menjalankan seluruh test
php artisan test

# Menjalankan test fitur KASI saja
php artisan test tests/Feature/Kasi/KasiDashboardTest.php
```
