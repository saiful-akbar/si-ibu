<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisBelanjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * insert data jenis belanja
         */
        DB::table('jenis_belanja')->insert([
            [
                'kategori_belanja' => "Barang",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_belanja' => "Jasa",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_belanja' => "Orang",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_belanja' => "Lain-Lain",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
