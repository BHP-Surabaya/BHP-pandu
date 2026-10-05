# Pandu BHP Surabaya (Modul Permohonan Wasiat Tertutup)

Aplikasi portal permohonan layanan dan sistem administrasi Balai Harta Peninggalan (BHP) Surabaya, dengan fokus utama pada alur pendaftaran, penyerahan, dan verifikasi permohonan wasiat tertutup.

---

## 📌 Prasyarat Sistem

Sebelum memulai instalasi, pastikan perangkat Anda sudah terpasang:
- **PHP** `>= 8.3` (Disarankan PHP 8.3 - 8.5)
  - Ekstensi PHP yang dibutuhkan: `pdo_mysql`, `openssl`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `curl`, `fileinfo`
- **Composer** `2.x`
- **Node.js** `>= 18.x` & **NPM**
- **Database Server**: MySQL `>= 8.0` / MariaDB / TiDB Cloud
- **Git**

---

## 🚀 Panduan Instalasi & Setup Pertama Kali

Ikuti langkah-langkah berikut secara berurutan:

### 1. Clone Repository
```bash
git clone https://github.com/BHP-Surabaya/BHP-pandu.git
cd BHP-pandu
```

### 2. Install Dependensi PHP (Composer)
```bash
composer install
```

### 3. Install Dependensi Frontend (NPM)
```bash
npm install
```

### 4. Konfigurasi Environment (`.env`)
Salin file template `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Generate application key:
```bash
php artisan key:generate
```

### 5. Konfigurasi Koneksi Database
Buka file `.env` di text editor Anda dan sesuaikan konfigurasi database:

#### A. Menggunakan MySQL Lokal (XAMPP / MySQL Service)
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bhp_permohonan_wasiat
DB_USERNAME=root
DB_PASSWORD=
```
> **Catatan:** Pastikan database `bhp_permohonan_wasiat` sudah dibuat di MySQL/phpMyAdmin sebelum menjalankan migrasi.

#### B. Menggunakan TiDB Cloud (SSL Connection)
```env
DB_CONNECTION=mysql
DB_HOST=gateway01.ap-southeast-1.prod.aws.tidbcloud.com
DB_PORT=4000
DB_DATABASE=bhp_permohonan_wasiat
DB_USERNAME=your_username.root
DB_PASSWORD=your_password
MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt
MYSQL_ATTR_SSL_VERIFY_SERVER_CERT=true
```

### 6. Jalankan Migrasi & Database Seeder
Jalankan migrasi tabel beserta data awal/demo:
```bash
php artisan migrate --seed
```

### 7. Buat Symbolic Link Storage (Untuk Upload Dokumen)
Aplikasi membutuhkan symbolic link agar file dokumen yang diunggah pemohon dapat diakses oleh sistem:
```bash
php artisan storage:link
```

### 8. Compile Asset Frontend
Kompilasi asset Vite (CSS & JS) untuk tampilan:
```bash
npm run build
```

### 9. Jalankan Aplikasi
Jalankan development server Laravel:
```bash
php artisan serve
```
Buka browser dan akses: [http://localhost:8000](http://localhost:8000)

> **Tips:** Anda juga dapat menggunakan perintah bawaan untuk menjalankan server Laravel dan Vite sekaligus:
> ```bash
> composer run dev
> ```

---

## 👥 Akun Default (Hasil Seeder)

Setelah menjalankan `php artisan db:seed` atau `migrate --seed`, Anda dapat masuk menggunakan akun demo berikut:

| Peran (Role) | Email | Password | Keterangan |
| :--- | :--- | :--- | :--- |
| **Petugas BHP** | `petugas@bhp.test` | `password` | Mengakses dashboard verifikasi petugas |
| **Pemohon** | `pemohon@bhp.test` | `password` | Mengakses portal pengajuan pemohon |
| **Pengguna Demo** | `test@example.com` | `password` | Akun pemohon umum |

---

## 🔄 Cara Menarik Pembaruan (Git Pull / Sinkronisasi)

Jika rekan tim memperbarui repository GitHub dan Anda ingin menyinkronkan laptop Anda:

```bash
# 1. Tarik pembaruan kode terbaru
git pull origin main

# 2. Update dependensi jika ada perubahan
composer install
npm install

# 3. Jalankan migrasi jika ada struktur tabel baru
php artisan migrate

# 4. Bersihkan cache Laravel
php artisan optimize:clear

# 5. Rebuild asset frontend
npm run build
```

---

## 🧪 Menjalankan Automated Test

Aplikasi ini dilengkapi pengujian fitur (Feature Tests) menggunakan PHPUnit:

```bash
# Menjalankan seluruh test
php artisan test

# Menjalankan pengujian tertentu (misal: pengujian profil)
php artisan test --filter=ProfileTest
```

---

## 📂 Struktur Utama Proyek

- `app/Http/Controllers/` : Controller alur permohonan wasiat, profil, dan otentikasi.
- `app/Models/` : Model Eloquent (`Permohonan`, `Pewasiat`, `Pasangan`, `AhliWaris`, `Dokumen`, `Voucher`, `User`).
- `database/migrations/` : Skema struktur database permohonan dan pengguna.
- `database/seeders/` : Seeder data awal pengguna dan permohonan.
- `resources/views/` : Template antarmuka Blade (BHP Surabaya theme, Alpine.js & Tailwind CSS).
- `routes/web.php` : Rute navigasi pemohon dan petugas.
