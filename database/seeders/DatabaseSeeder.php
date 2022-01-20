<?php

namespace Database\Seeders;

use Database\Seeders\Arsip\CategorySeeder;
use Database\Seeders\Arsip\TypeSeeder;
use Database\Seeders\DivisiSeeder;
use Database\Seeders\JenisBelanjaSeeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\UserMenuSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([

            /**
             * Anggaran seeder
             */
            DivisiSeeder::class,
            UserSeeder::class,
            AkunBelanjaSeeder::class,
            JenisBelanjaSeeder::class,
            MenuSeeder::class,
            UserMenuSeeder::class,

            /**
             * Arsip seeder
             */
            CategorySeeder::class,
            TypeSeeder::class,
        ]);
    }
}
