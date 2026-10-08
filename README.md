# Sistem Informasi Inventori Gudang Bahan Bangunan

Proyek Pemrograman Basis Data (Laravel + MySQL).

## Cara menjalankan
1. Buat database `db_gudang_bangunan` di MySQL
2. Import `database/sql/ddl.sql`, lalu `database/sql/dml.sql`
3. `composer install`
4. `cp .env.example .env` (Windows: `copy .env.example .env`), lalu sesuaikan konfigurasi DB
5. `php artisan key:generate`
6. `php artisan serve`

## Fitur
CRUD master: role, user, satuan, vendor, margin penjualan, barang.

## Pembuat
Leora Shieny Nethania - 434251079
