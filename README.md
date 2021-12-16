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
- Buka file .env di text editor
- Ubah value `DB_CONNECTION=` `DB_HOST=` `DB_PORT=` `DB_DATABASE=` `DB_USERNAME=` `DB_PASSWORD=` sesuai dengan pengaturan database anda
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
