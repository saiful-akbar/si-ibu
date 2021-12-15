<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('divisi')->insert([
            [
                'nama_divisi' => 'Admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_divisi' => 'IT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_divisi' => 'Accounting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
