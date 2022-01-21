<div align="center">
    <img
      loading="lazy"
      alt="logo"
      src="public/assets/images/logo/logo-dark.png"
      height="200"
    />
</div>

# SIMAA

Sistem informasi manajemen anggaran & arsip.

# Persyaratan

-   php v8.x
-   composer
-   git
-   Aktifkan `extension=gd` pada php.ini untuk fitur export excel dan domPDF
-   Ter-install driver SQL Server untuk php

# Instalasi Development

1.  Clone repository

```bash
git clone https://github.com/saiful-akbar/SIMAA.git
cd SIMAA
git checkout develop
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
DB_CONNECTION=anggaran
DB_HOST=localhost
DB_PORT=1433
DB_DATABASE=simaa_anggaran
DB_USERNAME=sa
DB_PASSWORD=

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

# Instalasi Production / Deployment

1.  Clone repository

```bash
git clone https://github.com/saiful-akbar/SIMAA.git
cd SIMAA
```

2. Instal dependencies composer & optimalisasi Autoloader

```bash
composer install --optimize-autoloader --no-dev
```

3. Copy file .htaccess & .env

```bash
cp .htaccess.example .htaccess && cp .env.example .env
```

4.  Buat generate:key & storage:link

```bash
php artisan key:generate && php artisan storage:link
```

5.  Buka file .env pada text editor & ubah value pada variable `DB_` & `APP_` di file .env

```php
APP_ENV=production
APP_DEBUG=false
APP_URL=https://www.domain.com

DB_CONNECTION=anggaran
DB_HOST=localhost
DB_PORT=1433
DB_DATABASE=simaa_anggaran
DB_USERNAME=sa
DB_PASSWORD=

DB_CONNECTION_SECOND=arsip
DB_HOST_SECOND=localhost
DB_PORT_SECOND=1433
DB_DATABASE_SECOND=simaa_arsip
DB_USERNAME_SECOND=sa
DB_PASSWORD_SECOND=
```

6. Ubah konfigurasi connections database pada file `config/database.php`

```php
'anggaran' => [
    'driver' => 'sqlsrv',
    'url' => env('DATABASE_URL'),
    'host' => env('DB_HOST', 'localhost'),
    'port' => env('DB_PORT', '1433'),
    'database' => env('DB_DATABASE', 'simaa_anggaran'),
    'username' => env('DB_USERNAME', 'sa'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8',
    'prefix' => '',
    'prefix_indexes' => true,
],

'arsip' => [
    'driver' => 'sqlsrv',
    'url' => env('DATABASE_URL_SECOND'),
    'host' => env('DB_HOST_SECOND', 'localhost'),
    'port' => env('DB_PORT_SECOND', '1433'),
    'database' => env('DB_DATABASE_SECOND', 'simaa_arsip'),
    'username' => env('DB_USERNAME_SECOND', 'sa'),
    'password' => env('DB_PASSWORD_SECOND', ''),
    'charset' => 'utf8',
    'prefix' => '',
    'prefix_indexes' => true,
],
```

7. Migrasi tabel ke database

```bash
php artisan migrate:refresh --seed
```

8. Mengoptimalkan konfigurasi `NB: semua panggilan fungsi env() akan mengembalikan nilai default (parameter kedua). dalam kata lain variabel pada file .env tidak terpakai lagi, semua konfigurasi akan diambil langsung dari semua file pada folder config`

```bash
php artisan config:cache
```

9. Mengoptimalkan View Loading

```bash
php artisan view:cache
```
