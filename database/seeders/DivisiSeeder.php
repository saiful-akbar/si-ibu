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
        DB::connection('sqlsrv')
            ->table('divisi')->insert([
                [
                    'nama_divisi' => 'IT',
                    'active'      => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'nama_divisi' => 'Accounting',
                    'active'      => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
                [
                    'nama_divisi' => 'Warehouse',
                    'active'      => true,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ],
            ]);
    }
}
