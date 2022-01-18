<?php

namespace Database\Seeders;

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
            DivisiSeeder::class,
            UserSeeder::class,
            AkunBelanjaSeeder::class,
            JenisBelanjaSeeder::class,
            MenuSeeder::class,
            UserMenuSeeder::class,
        ]);
    }
}
