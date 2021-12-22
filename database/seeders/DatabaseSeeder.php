<?php

namespace Database\Seeders;

use Database\Seeders\DivisiSeeder;
use Database\Seeders\JenisBelanjaSeeder;
use Database\Seeders\MenuSeeder;
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
            JenisBelanjaSeeder::class,
            UserSeeder::class,
            MenuSeeder::class,
        ]);
    }
}
