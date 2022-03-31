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

-   php v8.0 | v8.1
-   composer
-   git & git bash
-   Aktifkan `extension=gd` pada php.ini untuk fitur export excel dan domPDF
-   Ter-install driver SQL Server untuk php

# Instalasi

1.  Clone repository

```bash
git clone https://github.com/saiful-akbar/si-ibu.git && cd si-ibu
```

2. Instal dependencies composer & optimalisasi Autoloader

```bash
composer install --optimize-autoloader --no-dev
```

3. Copy file .env

```bash
cp .env.example .env
```

4.  Buka file .env & ubah value pada variable `APP_*` & `DB_*`

```php
APP_ENV=production
APP_DEBUG=false
APP_URL=https://www.domain.com

# Koneksi database pertama (Anggaran)
DB_CONNECTION_ANGGARAN=anggaran
DB_HOST_ANGGARAN=localhost
DB_PORT_ANGGARAN=1433
DB_DATABASE_ANGGARAN=simaa_anggaran
DB_USERNAME_ANGGARAN=sa
DB_PASSWORD_ANGGARAN=

# Koneksi database kedua (Arsip)
DB_CONNECTION_ARSIP=arsip
DB_HOST_ARSIP=localhost
DB_PORT_ARSIP=1433
DB_DATABASE_ARSIP=simaa_arsip
DB_USERNAME_ARSIP=sa
DB_PASSWORD_ARSIP=
```

5.  Buat generate:key & storage:link

```bash
php artisan key:generate && php artisan storage:link
```

6. Migrasi tabel ke database

```bash
php artisan migrate:refresh --seed
```

7. Optimalisasi konfigurasi & view

```bash
php artisan config:cache && php artisan view:cache
```
