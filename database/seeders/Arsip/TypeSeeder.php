<?php

namespace Database\Seeders\Arsip;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::connection('arsip')
            ->table('MSARSType')
            ->insert([
                [
                    'MSARSCategory_FK' => 1,
                    'Nama' => 'Type 1',
                ],
                [
                    'MSARSCategory_FK' => 1,
                    'Nama' => 'Type 2',
                ],
                [
                    'MSARSCategory_FK' => 2,
                    'Nama' => 'Type 3',
                ],
                [
                    'MSARSCategory_FK' => 2,
                    'Nama' => 'Type 4',
                ],
                [
                    'MSARSCategory_FK' => 3,
                    'Nama' => 'Type 5',
                ],
                [
                    'MSARSCategory_FK' => 3,
                    'Nama' => 'Type 6',
                ],
            ]);
    }
}
