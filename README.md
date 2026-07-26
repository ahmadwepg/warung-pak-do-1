# Warung Pak Do - Katalog Produk Toko Online

Warung Pak Do adalah sistem manajemen toko e-commerce sederhana untuk operasional warung atau toko lokal, mencakup panel admin untuk manajemen produk/pesanan dan storefront pelanggan untuk pemesanan.

## Fitur
- **Frontend Pelanggan:**
  - Katalog produk dengan filter kategori & pencarian.
  - Varian produk (misal: ukuran, tingkat kepedasan).
  - Keranjang belanja & sistem checkout.
  - Riwayat pesanan & ulasan pelanggan.
- **Panel Admin:**
  - CRUD Produk & Kategori.
  - Manajemen Varian Produk.
  - Update status pesanan (Diterima -> Disiapkan -> Dikirim -> Selesai).
  - Laporan & pengaturan toko.

## Tech Stack
- **Framework:** Laravel 11
- **Language:** PHP 8.2+
- **Database:** MySQL
- **Frontend:** TailwindCSS, Blade templates
- **Asset Build:** Vite

## Prasyarat
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM
- MySQL

## Instalasi
1. Clone repositori: `git clone <repository-url>`
2. Install dependensi PHP: `composer install`
3. Install dependensi JS: `npm install`
4. Salin file environment: `cp .env.example .env`
5. Generate key aplikasi: `php artisan key:generate`
6. Konfigurasi database di file `.env`.
7. Jalankan migrasi & seed: `php artisan migrate --seed`
8. Link storage: `php artisan storage:link`
9. Compile assets: `npm run dev`
10. Jalankan aplikasi: `php artisan serve`

## Environment Variables (.env)
Pastikan konfigurasi berikut diatur:
- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_DATABASE=warung_pak_do`
- `DB_USERNAME=root`
- `DB_PASSWORD=`
- `APP_DEBUG=true`

## User Roles
- **Admin:** Akses penuh ke `/admin` untuk manajemen produk, pesanan, dan laporan.
- **Customer:** Akses ke katalog menu, keranjang, checkout, dan riwayat pesanan pribadi.
