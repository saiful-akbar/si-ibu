<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insetUserMenuHeader();
        $this->insertUserMenuItem();
    }

    /**
     * insetUserMenu
     * insert data user_menu
     *
     * @return void
     */
    public function insetUserMenuHeader(): void
    {
        DB::connection('anggaran')
            ->table('user_menu_header')->insert([

                /**
                 * admin
                 */
                [
                    'user_id' => $this->getUser('admin'),
                    'menu_header_id' => $this->getMenuHeader('01. Utama'),
                    'read' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => $this->getUser('admin'),
                    'menu_header_id' => $this->getMenuHeader('02. Data Master'),
                    'read' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => $this->getUser('admin'),
                    'menu_header_id' => $this->getMenuHeader('03. Keuangan'),
                    'read' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => $this->getUser('admin'),
                    'menu_header_id' => $this->getMenuHeader('04. Arsip'),
                    'read' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                /**
                 * staff
                 */
                [
                    'user_id' => $this->getUser('staff'),
                    'menu_header_id' => $this->getMenuHeader('01. Utama'),
                    'read' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => $this->getUser('staff'),
                    'menu_header_id' => $this->getMenuHeader('02. Data Master'),
                    'read' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => $this->getUser('staff'),
                    'menu_header_id' => $this->getMenuHeader('03. Keuangan'),
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
        DB::connection('anggaran')
            ->table('user_menu_item')->insert([

                /**
                 * Admin
                 */
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
                    'menu_item_id' => $this->getMenuItem('Akun Belanja'),
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
                    'user_id' => $this->getUser('admin'),
                    'menu_item_id' => $this->getMenuItem('Dokumen Arsip'),
                    'create' => true,
                    'read' => true,
                    'update' => true,
                    'delete' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                /**
                 * staff
                 */
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
                    'menu_item_id' => $this->getMenuItem('Bagian'),
                    'create' => false,
                    'read' => true,
                    'update' => false,
                    'delete' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => $this->getUser('staff'),
                    'menu_item_id' => $this->getMenuItem('Akun Belanja'),
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
                ],
                [
                    'user_id' => $this->getUser('staff'),
                    'menu_item_id' => $this->getMenuItem('Budget'),
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

    /**
     * getMenuItem
     * ambil id dari menu item berdasarkan nama menu
     *
     * @param  string $nama
     * @return void
     */
    public function getMenuItem(string $nama): int
    {
        $menuItem = DB::connection('anggaran')
            ->table('menu_item')
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
        $user = DB::connection('anggaran')
            ->table('user')
            ->where('username', $username)
            ->first();

        return $user->id;
    }
}
