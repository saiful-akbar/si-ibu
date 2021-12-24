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
        /**
         * buat data menu header
         */
        DB::table('menu_header')->insert([
            [
                'nama_header' => 'Halaman Utama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_header' => 'Data Master',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_header' => 'Keuangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_header' => 'Laporan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);



        /**
         * Jalankan fungsi insert
         */
        $this->insertMenuItem();
        $this->insetUserMenu();
    }

    /**
     * insertMenuItem
     * insert data menu_item ke database
     *
     * @return void
     */
    public function insertMenuItem()
    {
        DB::table('menu_item')->insert([
            [
                'menu_header_id' => $this->getMenuHeader('Halaman Utama'),
                'nama_menu' => 'dashboard',
                'icon' => 'fas fa-home',
                'href' => '/dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_header_id' => $this->getMenuHeader('Data Master'),
                'nama_menu' => 'divisi',
                'icon' => 'fas fa-boxes',
                'href' => '/divisi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_header_id' => $this->getMenuHeader('Data Master'),
                'nama_menu' => 'jenis belanja',
                'icon' => 'fas fa-shopping-cart',
                'href' => '/jenis-belanja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_header_id' => $this->getMenuHeader('Data Master'),
                'nama_menu' => 'user',
                'icon' => 'fas fa-users',
                'href' => '/user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_header_id' => $this->getMenuHeader('keuangan'),
                'nama_menu' => 'budget',
                'icon' => 'fas fa-funnel-dollar',
                'href' => '/budget',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_header_id' => $this->getMenuHeader('keuangan'),
                'nama_menu' => 'transaksi',
                'icon' => 'fas fa-handshake',
                'href' => '/transaksi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_header_id' => $this->getMenuHeader('Laporan'),
                'nama_menu' => 'Laporan Transaksi',
                'icon' => 'fas fa-newspaper',
                'href' => '/laporan-transaksi',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * insetUserMenu
     * insert data user_menu
     *
     * @return void
     */
    public function insetUserMenu()
    {
        /**
         * buata data user menu header
         */
        DB::table('user_menu_header')->insert([
            [
                'user_id' => $this->getUser('admin'),
                'menu_header_id' => $this->getMenuHeader('Halaman Utama'),
                'read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_header_id' => $this->getMenuHeader('Data Master'),
                'read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_header_id' => $this->getMenuHeader('Keuangan'),
                'read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_header_id' => $this->getMenuHeader('Laporan'),
                'read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('staff'),
                'menu_header_id' => $this->getMenuHeader('Halaman Utama'),
                'read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        /**
         * buata data user menu item
         */
        DB::table('user_menu_item')->insert([
            [
                'user_id' => $this->getUser('admin'),
                'menu_item_id' => $this->getMenuItem('Dashboard'),
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_item_id' => $this->getMenuItem('Divisi'),
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_item_id' => $this->getMenuItem('Jenis Belanja'),
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_item_id' => $this->getMenuItem('User'),
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_item_id' => $this->getMenuItem('Budget'),
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_item_id' => $this->getMenuItem('Transaksi'),
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_item_id' => $this->getMenuItem('Laporan Transaksi'),
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('staff'),
                'menu_item_id' => $this->getMenuItem('dashboard'),
                'create' => false,
                'read' => true,
                'update' => false,
                'delete' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * getMenuHeader
     * ambil id dari menu header berdasarkan nama menu
     *
     * @param  mixed $nama
     * @return void
     */
    public function getMenuHeader(string $nama)
    {
        $menuHeader = DB::table('menu_header')
            ->where('nama_header', $nama)
            ->first();

        return $menuHeader->id;
    }

    /**
     * getMenuItem
     * ambil id dari menu item berdasarkan nama menu
     *
     * @param  mixed $nama
     * @return void
     */
    public function getMenuItem(string $nama)
    {
        $menuItem = DB::table('menu_item')
            ->where('nama_menu', $nama)
            ->first();

        return $menuItem->id;
    }

    /**
     * getUser
     * ambil id user berdasarkan username
     *
     * @param  string $username
     * @return void
     */
    public function getUser(String $username)
    {
        $user = DB::table('user')
            ->where('username', $username)
            ->first();

        return $user->id;
    }
}
