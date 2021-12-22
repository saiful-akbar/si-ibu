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
                // id 1
                'nama_header' => 'utama',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // id 2
                'nama_header' => 'data master',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // id 2
                'nama_header' => 'keuangan',
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
                // id 1
                'menu_header_id' => $this->getMenuHeader('utama'),
                'nama_menu' => 'dashboard',
                'icon' => 'fas fa-home',
                'href' => '/dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // id 2
                'menu_header_id' => $this->getMenuHeader('data master'),
                'nama_menu' => 'divisi',
                'icon' => 'fas fa-boxes',
                'href' => '/divisi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // id 2
                'menu_header_id' => $this->getMenuHeader('data master'),
                'nama_menu' => 'jenis belanja',
                'icon' => 'fas fa-shopping-cart',
                'href' => '/jenis-belanja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // id 3
                'menu_header_id' => $this->getMenuHeader('data master'),
                'nama_menu' => 'user',
                'icon' => 'fas fa-users',
                'href' => '/user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // id 4
                'menu_header_id' => $this->getMenuHeader('keuangan'),
                'nama_menu' => 'budget',
                'icon' => 'fas fa-money-check-alt',
                'href' => '/budget',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // id 4
                'menu_header_id' => $this->getMenuHeader('keuangan'),
                'nama_menu' => 'transaksi',
                'icon' => 'fas fa-file-invoice-dollar',
                'href' => '/transaksi',
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
                'menu_header_id' => $this->getMenuHeader('utama'),
                'read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_header_id' => $this->getMenuHeader('data master'),
                'read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_header_id' => $this->getMenuHeader('keuangan'),
                'read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('staff'),
                'menu_header_id' => $this->getMenuHeader('utama'),
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
                'menu_item_id' => $this->getMenuItem('dashboard'),
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_item_id' => $this->getMenuItem('divisi'),
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_item_id' => $this->getMenuItem('jenis belanja'),
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_item_id' => $this->getMenuItem('user'),
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_item_id' => $this->getMenuItem('budget'),
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('admin'),
                'menu_item_id' => $this->getMenuItem('transaksi'),
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
