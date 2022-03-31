<div align="center">
  <img
      loading="lazy"
      alt="logo"
      src="public/assets/images/logo/logo-dark.png"
      height="150"
   />
</div>

# Si-IBU

Sistem Informasi Bagian Umum.

# Persyaratan

-   php v8.0 | v8.1
-   composer
-   git & git bash
-   Aktifkan `extension=gd` pada php.ini untuk fitur export excel dan domPDF
-   Ter-install driver SQL Server untuk php

# Daftar Pembaruan

-   [x] Chat Pie Dashboard.

    > Filter pada chart pie paling bawah di halaman dashboard dibenahi.
    > Jangan tampilkan seluruh data pada form select-nya, tampilkan hanya sesui data yang dipilih pada form select parant-nya.

-   [x] Transaksi/Belanja.

    > Bagian umum & kepala kantor dapat input belanja untuk semua akun belanja,
    > dimana yang sekarang hanya sesuai bagian-nya masing-masing.

-   [x] Transaksi/Belanja.

    > Tambah 1 kolom `outstanding` pada tambel transaksi/belanja, untuk mengetahui biaya masih outstanding atau tidak.
    > Gunakan tipe data boolean saja untuk kolom-nya

-   [x] Budget

    > Tambahn 1 kolom pada tabel **hanyan pada view saja** bukan di database.
    > Untuk menampilkan biaya atau total nominal belanja yang sudah digunakan & buat chart pie-nya pada dashboard.

-   [x] Budget & Transaksi/Belanja

    > Ganti penamaan budget menjadi `pagu` & belanja menjadi `readlisasi` hanya pada view saja.

-   [x] Transaksi/Belanja.
    > Periksa datatable pada modal untuk memilih akun belanja di halaman `Input Belanja` & `Edit Belanja`

# Instalasi

## Instalasi Development

1.  Clone repository

```bash
git clone https://github.com/saiful-akbar/si-ibu.git && cd si-ibu && git checkout develop
```

2.  Instal dependencies composer

```bash
composer install
```

3.  Copy file .env

```bash
cp .env.example .env
```

4.  Buat database
5.  Buka file .env di text editor & ubah value pada variable `DB_` di file .env sesuai dengan pengaturan database anda

```php
# Koneksi database pertama (Anggaran)
DB_CONNECTION=anggaran
DB_HOST=localhost
DB_PORT=1433
DB_DATABASE=simaa_anggaran
DB_USERNAME=sa
DB_PASSWORD=

# Koneksi database kedua (Arsip)
DB_CONNECTION_SECOND=arsip
DB_HOST_SECOND=localhost
DB_PORT_SECOND=1433
DB_DATABASE_SECOND=simaa_arsip
DB_USERNAME_SECOND=sa
DB_PASSWORD_SECOND=
```

6.  Buat generate:key & storage:link

```bash
php artisan key:generate && php artisan storage:link
```

7. Migrasi tabel database

```bash
php artisan migrate:refresh --seed
```

8.  Jalankan local server

```bash
php artisan serve
```

## Instalasi Production

1.  Clone repository

```bash
git clone https://github.com/saiful-akbar/si-ibu.git && cd si-ibu
```

2. Instal dependencies composer & optimalisasi Autoloader

```bash
composer install --optimize-autoloader --no-dev
```

3. Copy file .htaccess & .env

```bash
cp .htaccess.example .htaccess && cp .env.example .env
```

4.  Buka file .env pada text editor & ubah value pada variable `DB_` & `APP_` di file .env

```php
APP_ENV=production
APP_DEBUG=false
APP_URL=https://www.domain.com

# Koneksi database pertama (Anggaran)
DB_CONNECTION=anggaran
DB_HOST=localhost
DB_PORT=1433
DB_DATABASE=simaa_anggaran
DB_USERNAME=sa
DB_PASSWORD=

# Koneksi database kedua (Arsip)
DB_CONNECTION_SECOND=arsip
DB_HOST_SECOND=localhost
DB_PORT_SECOND=1433
DB_DATABASE_SECOND=simaa_arsip
DB_USERNAME_SECOND=sa
DB_PASSWORD_SECOND=
```

5.  Buat generate:key & storage:link

```bash
php artisan key:generate && php artisan storage:link
```

6. Migrasi tabel ke database

```bash
php artisan migrate:refresh --seed
```

7. Mengoptimalkan konfigurasi

```bash
# Semua panggilan fungsi env() akan mengembalikan nilai default (parameter kedua), dalam kata lain variabel pada...
# ...file .env tidak terpakai lagi semua konfigurasi akan diambil langsung dari semua file pada folder config
php artisan config:cache
```

8. Mengoptimalkan View Loading

```bash
php artisan view:cache
```
