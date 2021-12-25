## Persyaratan

-   php v8.x
-   composer
-   git
-   Aktifkan `extension=gd` pada php.ini untuk fitur export excel dan domPDF

## Instalasi

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
cp .evn.example .env
```

4.  Buat database di mysql
5.  Buka file .env di text editor
6.  Ubah value pada variable database di file `.env` sesuai dengan pengaturan database anda

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_laravel_anggaran
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
