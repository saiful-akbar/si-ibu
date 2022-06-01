<div align="center">
  <img
      loading="lazy"
      alt="logo"
      src="public/assets/images/logo/logo-dark.png"
      height="140"
   />
</div>

# Si-IBU

Sistem Informasi Bagian Umum.

# Persyaratan

-   php v8.x.x
-   composer
-   git & git bash
-   Aktifkan `extension=gd` pada php.ini untuk fitur export excel dan domPDF
-   Ter-install driver SQL Server untuk php

# Update v2.1.0

1.  Perbaikan form filter pada chart pie.
2.  Perubahan nama `Budget` menjadi `Pagu`.
3.  Perubahan nama `Belanja` menjadi `Realisasi`.
4.  Menambah kolom `Nominal Realisasi` pada tabel view (bukan di database) pada halaman pagu.
5.  Menambah kolom `outstanding` pada tabel transaksi di database.
6.  Sekarang khusus `bagian umum` & `kepala kantor` dapat input realisasi untuk semua akun belanja.
7.  Penambahan form filter by nama file pada halaman arsip dokumen.

# Instalasi

1.  Clone repository

```bash
git clone https://github.com/saiful-akbar/si-ibu.git && cd si-ibu
```

2. Instal dependencies composer & optimalisasi autoloader

```bash
composer install --optimize-autoloader --no-dev
```

3. Copy file .env.example ke .env & generate:key

```bash
cp .env.example .env && php artisan key:generate
```

4.  Buka file .env & ubah value pada variable `APP_*` & `DB_*`

```php
APP_ENV= # local | production
APP_DEBUG= # true | false
APP_URL= #https://www.siibu.com

# Koneksi database pertama (Anggaran)
DB_CONNECTION_ANGGARAN=anggaran
DB_HOST_ANGGARAN= # localhost
DB_PORT_ANGGARAN= # 1433
DB_DATABASE_ANGGARAN= # siibu_anggaran
DB_USERNAME_ANGGARAN= # sa
DB_PASSWORD_ANGGARAN= # secret

# Koneksi database kedua (Arsip)
DB_CONNECTION_ARSIP=arsip
DB_HOST_ARSIP= # localhost
DB_PORT_ARSIP= # 1433
DB_DATABASE_ARSIP= # siibu_arsip
DB_USERNAME_ARSIP= # sa
DB_PASSWORD_ARSIP= # secret
```

5.  Buat storage:link

```bash
php artisan storage:link
```

6. Migrasi tabel ke database.

```bash
# Note:
# Jangan lakukan migrasi jika database sebelumnya sudah ada.
# Karena akan menghilangkan semua table & record pada database sebelumnya.
php artisan migrate:refresh --seed
```

7. Optimalisasi.

```bash
php artisan optimize && php artisan view:cache && php artisan route:clear
```
