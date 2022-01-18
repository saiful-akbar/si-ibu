<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertMenuHeader();
        $this->insertMenuItem();
    }

    /**
     * insertMenuHeader
     * insert data menu_header
     *
     * @return void
     */
    public function insertMenuHeader(): void
    {
        /**
         * gunakan penomoran pada nama_header untuk pengurutan di view (interface)
         */
        DB::connection('anggaran')
            ->table('menu_header')->insert([
                [
                    'nama_header' => '01. Utama',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama_header' => '02. Data Master',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama_header' => '03. Keuangan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'nama_header' => '04. Arsip',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
    }

    /**
     * insertMenuItem
     * insert data menu_item ke database
     *
     * @return void
     */
    public function insertMenuItem(): void
    {
        DB::connection('anggaran')
            ->table('menu_item')->insert([

                /**
                 * Halaman utama
                 */
                [
                    'menu_header_id' => $this->getMenuHeader('01. Utama'),
                    'nama_menu' => 'Dashboard',
                    'icon' => 'uil-home-alt',
                    'href' => '/dashboard',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                /**
                 * Data Master
                 */
                [
                    'menu_header_id' => $this->getMenuHeader('02. Data Master'),
                    'nama_menu' => 'Akun Belanja',
                    'icon' => 'uil-store-alt',
                    'href' => '/akun-belanja',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'menu_header_id' => $this->getMenuHeader('02. Data Master'),
                    'nama_menu' => 'Bagian',
                    'icon' => 'uil-th',
                    'href' => '/divisi',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'menu_header_id' => $this->getMenuHeader('02. Data Master'),
                    'nama_menu' => 'User',
                    'icon' => 'uil-users-alt',
                    'href' => '/user',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                /**
                 * Keuangan
                 */
                [
                    'menu_header_id' => $this->getMenuHeader('03. keuangan'),
                    'nama_menu' => 'Belanja',
                    'icon' => 'uil-shopping-cart-alt',
                    'href' => '/belanja',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'menu_header_id' => $this->getMenuHeader('03. keuangan'),
                    'nama_menu' => 'Budget',
                    'icon' => 'uil-moneybag',
                    'href' => '/budget',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                /**
                 * Arsip
                 */
                [
                    'menu_header_id' => $this->getMenuHeader('04. Arsip'),
                    'nama_menu' => 'Dokumen Arsip',
                    'icon' => 'uil-document',
                    'href' => '/arsip/dokumen',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
    }

    /**
     * ambil id dari menu header berdasarkan nama menu
     * @param string $nama
     *
     * @return int
     */
    public function getMenuHeader(string $nama): int
    {
        $menuHeader = DB::connection('anggaran')
            ->table('menu_header')
            ->where('nama_header', $nama)
            ->first();

        return $menuHeader->id;
    }
}
