<?php

namespace Database\Seeders\Arsip;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('arsip')
            ->table('MSARSCategory')
            ->insert([
                ['Nama' => 'Category 1'],
                ['Nama' => 'Category 2'],
                ['Nama' => 'Category 3'],
            ]);
    }
}
