## Persyaratan

-   php v8.x
-   composer
-   git
-   Aktifkan `extension=gd` pada php.ini untuk fitur export excel dan domPDF

## Development Instalasi

1.  Clone repository

```bash
git clone https://github.com/saiful-akbar/laravel-anggaran.git
cd laravel_anggaran
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

4.  Buat database di mysql
5.  Buka file .env di text editor
6.  Ubah value pada variable `DB_` di file `.env` sesuai dengan pengaturan database anda

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_anggaran
DB_USERNAME=root
DB_PASSWORD=
```

7.  Buat generate:key, storage:link & migrasi table ke database

```bash
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed
```

8.  Jalankan local server

```bash
php artisan serve
```

## Production / Deployment

1. Copy file .htaccess

```bash
cp .htaccess.example .htaccess
```

2.  Buka file .env di text editor
3.  Ubah value pada variable `DB_` & `APP_` di file `.env`

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain.com

DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

4. Optimasi Autoloader

```bash
composer install --optimize-autoloader --no-dev
```

5. Mengoptimalkan Route Loading

```bash
php artisan route:cache
```

6. Mengoptimalkan View Loading

```bash
php artisan view:cache
```
