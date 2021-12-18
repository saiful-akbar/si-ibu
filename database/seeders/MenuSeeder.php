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
        ]);

        /**
         * buat data menu item
         */
        DB::table('menu_item')->insert([
            [
                // id 1
                'menu_header_id' => 1,
                'nama_menu' => 'dashboard',
                'icon' => 'fas fa-home',
                'href' => '/dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // id 2
                'menu_header_id' => 2,
                'nama_menu' => 'divisi',
                'icon' => 'fas fa-boxes',
                'href' => '/divisi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                // id 3
                'menu_header_id' => 2,
                'nama_menu' => 'user',
                'icon' => 'fas fa-users',
                'href' => '/user',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        /**
         * buata data user menu header
         */
        DB::table('user_menu_header')->insert([
            [
                'user_id' => 1,
                'menu_header_id' => 1,
                'read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'menu_header_id' => 2,
                'read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'menu_header_id' => 1,
                'read' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        /**
         * buata data user menu item
         */
        DB::table('user_menu_item')->insert([
            [
                'user_id' => 1,
                'menu_item_id' => 1,
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'menu_item_id' => 2,
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'menu_item_id' => 3,
                'create' => true,
                'read' => true,
                'update' => true,
                'delete' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'menu_item_id' => 1,
                'create' => false,
                'read' => true,
                'update' => false,
                'delete' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
