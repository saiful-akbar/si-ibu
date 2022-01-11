<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunBelanjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('akun_belanja')->insert([[
            'nama_akun_belanja' => 'Barang',
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]]);
    }
}
