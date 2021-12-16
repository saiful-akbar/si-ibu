## Persyaratan
- php v8.x
- composer
- git

## Instalasi
- Clone repository
```bash
git clone https://github.com/saiful-akbar/laravel-anggaran.git
cd laravel_anggaran
git checkout develop
```
- Instal dependencies composer
```bash
composer install
```
- Copy file .env
```bash
cp .evn.example .env
```
- Buat database di mysql
- Buka file .env di text editor
- Ubah value pada variable database di file `.env` sesuai dengan pengaturan database anda
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_laravel_anggaran
DB_USERNAME=root
DB_PASSWORD=
```
- Buat generate:key, storage:link & migrasi table ke database
```bash
php artisan key:generate
php artisan storage:link
php artisan migrate:fresh --seed
```
- Jalankan local server
```bash
php artisan serve
```