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
                    'no_urut' => 1,
                    'nama_header' => 'Utama',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'no_urut' => 2,
                    'nama_header' => 'Data Master',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'no_urut' => 3,
                    'nama_header' => 'Keuangan',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'no_urut' => 4,
                    'nama_header' => 'Arsip',
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
                    'menu_header_id' => $this->getMenuHeader('Utama'),
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
                    'menu_header_id' => $this->getMenuHeader('Data Master'),
                    'nama_menu' => 'Akun Belanja',
                    'icon' => 'uil-store-alt',
                    'href' => '/akun-belanja',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'menu_header_id' => $this->getMenuHeader('Data Master'),
                    'nama_menu' => 'Bagian',
                    'icon' => 'uil-th',
                    'href' => '/divisi',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'menu_header_id' => $this->getMenuHeader('Data Master'),
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
                    'menu_header_id' => $this->getMenuHeader('keuangan'),
                    'nama_menu' => 'Belanja',
                    'icon' => 'uil-shopping-cart-alt',
                    'href' => '/belanja',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'menu_header_id' => $this->getMenuHeader('keuangan'),
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
                    'menu_header_id' => $this->getMenuHeader('Arsip'),
                    'nama_menu' => 'Dokumen',
                    'icon' => 'uil-document',
                    'href' => '/arsip/dokumen',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'menu_header_id' => $this->getMenuHeader('Arsip'),
                    'nama_menu' => 'Master',
                    'icon' => 'uil-layer-group',
                    'href' => '/arsip/master',
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
