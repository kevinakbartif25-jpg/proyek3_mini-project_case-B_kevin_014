# Sistem Pelaporan dan Pemantauan Karhutla (Kasus B)
Mini Project Proyek 3 - D3 Teknik Informatika

## Identitas
- Nama: Kevin Akbar Darmawan
- NIM: 251511014
- Kelas: 2A - D3 Teknik Informatika

## Kebutuhan Environment
- PHP >= 8.2
- Composer
- MySQL / MariaDB (XAMPP)
- Web Browser dengan JavaScript aktif

## Langkah Konfigurasi
1. Clone repository ini:
   ```bash
   git clone <URL_REPOSITORY>
   cd MiniProject-Karhutla
   ```
2. Salin environment dan sesuaikan koneksi database di .env:
   ```bash
   cp .env.example .env
   ```
   Pastikan konfigurasi database di .env:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_karhutla
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Install dependensi Composer:
   ```bash
   composer install
   ```
4. Generate application key dan tautan storage:
   ```bash
   php artisan key:generate
   php artisan storage:link
   ```
5. Jalankan migrasi tabel dan seeding data demo:
   ```bash
   php artisan migrate:fresh --seed
   ```

## Akun Demo Pengujian
Semua akun demo menggunakan password default: password123
Role                   |Username
- Pelapor 1            :kevin
- Pelapor 2            :raihan
- Relawan Pemantau     :lycoris
- Koordinator Relawan  :skirk

## Cara Menjalankan Aplikasi
1. Jalankan development server:
   ```bash
   php artisan serve
   ```
2. Buka aplikasi di browser:
   http://127.0.0.1:8000
