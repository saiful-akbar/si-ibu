<div align="center">
    <img
      loading="lazy"
      alt="logo"
      src="public/assets/images/logo/logo-dark.png"
      height="150"
    />
</div>

# SiIBU
Sistem Informasi Bagian Umum.

# Persyaratan

-   php v8.0 | v8.1
-   composer
-   git
-   Aktifkan `extension=gd` pada php.ini untuk fitur export excel dan domPDF
-   Ter-install driver SQL Server untuk php

# Instalasi Development

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

5.  Buat generate:key & storage:link

```bash
php artisan key:generate && php artisan storage:link
```

6. Migrasi tabel ke database

```bash
php artisan migrate:refresh --seed
```

7. Mengoptimalkan konfigurasi `NB: semua panggilan fungsi env() akan mengembalikan nilai default (parameter kedua). dalam kata lain variabel pada file .env tidak terpakai lagi, semua konfigurasi akan diambil langsung dari semua file pada folder config`

```bash
php artisan config:cache
```

8. Mengoptimalkan View Loading

```bash
php artisan view:cache
```
