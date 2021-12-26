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
        $this->insetUserMenuHeader();
        $this->insertUserMenuItem();
    }

    /**
     * insertMenuHeader
     * insert data menu_header
     *
     * @return void
     */
    public function insertMenuHeader(): void
    {
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
        DB::table('menu_item')->insert([
            [
                'menu_header_id' => $this->getMenuHeader('Halaman Utama'),
                'nama_menu' => 'Dashboard',
                'icon' => 'fas fa-home',
                'href' => '/dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_header_id' => $this->getMenuHeader('Data Master'),
                'nama_menu' => 'Bagian',
                'icon' => 'fas fa-boxes',
                'href' => '/bagian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_header_id' => $this->getMenuHeader('Data Master'),
                'nama_menu' => 'Jenis Belanja',
                'icon' => 'fas fa-store',
                'href' => '/jenis-belanja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_header_id' => $this->getMenuHeader('Data Master'),
                'nama_menu' => 'User',
                'icon' => 'fas fa-users',
                'href' => '/user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_header_id' => $this->getMenuHeader('keuangan'),
                'nama_menu' => 'Budget',
                'icon' => 'fas fa-funnel-dollar',
                'href' => '/budget',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'menu_header_id' => $this->getMenuHeader('keuangan'),
                'nama_menu' => 'Belanja',
                'icon' => 'fas fa-shopping-cart',
                'href' => '/belanja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * insetUserMenu
     * insert data user_menu
     *
     * @return void
     */
    public function insetUserMenuHeader(): void
    {
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
                'user_id' => $this->getUser('staff'),
                'menu_header_id' => $this->getMenuHeader('Halaman Utama'),
                'read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('staff'),
                'menu_header_id' => $this->getMenuHeader('Keuangan'),
                'read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * insertUserMenu
     * insert data user_menu_item
     *
     * @return void
     */
    public function insertUserMenuItem(): void
    {
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
                'menu_item_id' => $this->getMenuItem('Bagian'),
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
                'menu_item_id' => $this->getMenuItem('Belanja'),
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('staff'),
                'menu_item_id' => $this->getMenuItem('Dashboard'),
                'create' => false,
                'read' => true,
                'update' => false,
                'delete' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => $this->getUser('staff'),
                'menu_item_id' => $this->getMenuItem('Belanja'),
                'create' => true,
                'read' => true,
                'update' => false,
                'delete' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
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
        $menuHeader = DB::table('menu_header')
            ->where('nama_header', $nama)
            ->first();

        return $menuHeader->id;
    }

    /**
     * getMenuItem
     * ambil id dari menu item berdasarkan nama menu
     *
     * @param  string $nama
     * @return void
     */
    public function getMenuItem(string $nama): int
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
    public function getUser(String $username): int
    {
        $user = DB::table('user')
            ->where('username', $username)
            ->first();

        return $user->id;
    }
}
