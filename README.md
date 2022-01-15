<div align="center">
    <img
      loading="lazy"
      alt="logo"
      src="public/assets/images/logo/logo-dark.png"
      height="150"
    />
</div>

# SIMAA

Sistem informasi manajemen anggaran & arsip.

# Persyaratan

-   php v8.x
-   composer
-   git
-   Aktifkan `extension=gd` pada php.ini untuk fitur export excel dan domPDF

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

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_simaa
DB_USERNAME=root
DB_PASSWORD=
```

6.  Buat generate:key, storage:link & migrasi table ke database

```bash
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed
```

7.  Jalankan local server

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

3. Copy file .htaccess

```bash
cp .htaccess.example .htaccess
```

4.  Copy file .env

```bash
cp .env.example .env
```

5.  Buka file .env pada text editor & ubah value pada variable `DB_` & `APP_` di file .env

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
6.  Buat generate:key, storage:link & migrasi table ke database

```bash
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed
```

7. Mengoptimalkan route loading

```bash
php artisan route:cache
```

8. Mengoptimalkan View Loading

```bash
php artisan view:cache
```
