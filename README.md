# API Simple CRM

API Simple CRM adalah sebuah layanan **REST API** yang dikembangkan menggunakan **Laravel 11**. API ini dirancang untuk mendukung pengelolaan data perusahaan dan karyawan.

## Packages

- [**PEST PHP**](https://pestphp.com): Framework yang digunakan untuk pengujian.
- [**PEST Laravel plugin**](https://pestphp.com/docs/plugins#laravel): Plugin tambahan untuk integrasi PEST dengan Laravel.
- [**JWT Auth**](https://github.com/php-open-source-saver/jwt-auth): Digunakan untuk autentikasi berbasis JWT (JSON Web Token).
- [**Scramble**](https://scramble.dedoc.co): Digunakan untuk menghasilkan dokumentasi API otomatis.

## Daftar Isi

- [Persyaratan](#persyaratan)
- [Instalasi](#instalasi)
- [Konfigurasi Awal](#konfigurasi-awal)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Akses Layanan](#akses-layanan)
- [Pengujian](#pengujian)

### Persyaratan

Pastikan Anda telah memenuhi persyaratan berikut sebelum memulai instalasi:

- **PHP** 8.2^
- **Composer**
- **Docker** dan **Docker Compose**

### Instalasi

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

1. Salin konfigurasi dari `.env.example` ke `.env`:

    ```bash
    cp .env.example .env
    ```

2. Atur konfigurasi database di file `.env`:

    ```plaintext
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=simple_crm_db
    DB_USERNAME=root
    DB_PASSWORD=secret
    ```

   **Catatan**: Sesuaikan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` dengan konfigurasi yang Anda inginkan.

### Menjalankan Aplikasi

1. **Bangun dan jalankan kontainer** menggunakan Docker Compose:

    ```bash
    docker-compose up -d
    ```

    Perintah ini akan membangun dan menjalankan kontainer `crm-app`, `crm-webserver`, `crm-db` dan `crm-phpmyadmin`.

2. **Install dependensi Composer**:

    ```bash
    docker exec -it crm-app composer install
    ```

3. **Generate application key**:

    ```bash
    docker exec -it crm-app php artisan key:generate
    ```

4. **Jalankan Queue Worker** untuk memproses job di latar belakang:

    ```bash
    docker exec -it crm-app php artisan queue:work
    ```

5. **Jalankan migrasi dan seeder** untuk menginisialisasi database dengan data default:

    ```bash
    docker exec -it crm-app php artisan migrate
    docker exec -it crm-app php artisan db:seed
    ```

### Akses Layanan

- **Dokumentasi API**: [http://localhost:8000/docs/api](http://localhost:8000/docs/api)
- **phpMyAdmin**: [http://localhost:8001](http://localhost:8001)

### Pengujian

Untuk menjalankan pengujian otomatis:

```bash
docker exec -it crm-app php artisan test
```

Untuk pengujian manual menggunakan Postman, impor koleksi berikut:
[Postman Collection](https://github.com/damaskus92/simple-crm/blob/main/resources/PostmanTest.postman_collection.json)

## Penulis

[Damas Eka K](https://www.github.com/damaskus92)
