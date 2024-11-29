# API Simple CRM

Proyek ini adalah REST-API yang dibangun menggunakan Laravel 11. API ini menyediakan endpoint untuk mengelola perusahaan dan karyawan.

Untuk melihat daftar lengkap endpoint API, silakan kunjungi [Dokumentasi API](http://localhost:8000/docs/api).

> **Catatan**: Pastikan untuk menjalankan Docker terlebih dahulu sebelum mengakses link dokumentasi.

## Persyaratan

- PHP 8.2^
- Composer
- MySQL
- Docker

## Daftar Isi

- [Instalasi](#instalasi)
- [Konfigurasi Awal](#konfigurasi-awal)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Akses Layanan](#akses-layanan)
- [Pengujian](#pengujian)

## Instalasi

Ikuti langkah-langkah berikut untuk menginstal proyek ini:

1. **Clone** repositori yang berisi proyek Laravel.

    ```bash

    git clone git@github.com:damaskus92/simple-crm.git

    ```

2. **Masuk ke direktori proyek** dengan perintah:

    ```bash
    cd simple-crm
    ```

## Konfigurasi Awal

Buat file `.env` dan salin konfigurasi dari `.env.example` kemudian atur koneksi database.

```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=simple_crm_db
DB_USERNAME=root
DB_PASSWORD=secret
```

Pastikan untuk mengganti `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` sesuai dengan konfigurasi Anda.

## Menjalankan Aplikasi

1. Gunakan Docker Compose untuk membangun dan memulai kontainer:

    ```bash
    docker-compose up -d
    ```

2. Install dependensi Composer

    ```bash
    docker exec -it crm-app composer install
    ```

3. Generate aplikasi key

    ```bash
    docker exec -it crm-app php artisan key:generate
    ```

4. Jalankan Queue Worker untuk memproses job di background

    ```bash
    docker exec -it crm-app php artisan queue:work
    ```

5. Jalankan migrasi dan juga seeder untuk menghasilkan data default

    ```bash
    docker exec -it crm-app php artisan migrate
    docker exec -it crm-app php artisan db:seed
    ```

## Akses Layanan

- **Dokumentasi API**: [http://localhost:8000/docs/api](http://localhost:8000/docs/api)
- **phpMyAdmin**: [http://localhost:8001](http://localhost:8001)

## Pengujian

```bash
docker exec -it crm-app php artisan test
```

## Penulis

[Damas Eka K](https://www.github.com/damaskus92)
