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
        DB::connection('anggaran')
            ->table('divisi')->insert([
                [
                    'nama_divisi' => 'Kepala Kantor',
                    'active'      => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'nama_divisi' => 'Bagian Umum',
                    'active'      => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
            ]);
    }
}
