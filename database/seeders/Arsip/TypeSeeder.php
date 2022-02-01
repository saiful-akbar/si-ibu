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
                    'Name' => 'Type 1',
                    'Description' => 'Description 1',
                ],
                [
                    'MSARSCategory_FK' => 1,
                    'Name' => 'Type 2',
                    'Description' => 'Description 2',
                ],
                [
                    'MSARSCategory_FK' => 2,
                    'Name' => 'Type 3',
                    'Description' => 'Description 3',
                ],
                [
                    'MSARSCategory_FK' => 2,
                    'Name' => 'Type 4',
                    'Description' => 'Description 4',
                ],
                [
                    'MSARSCategory_FK' => 3,
                    'Name' => 'Type 5',
                    'Description' => 'Description 5',
                ],
                [
                    'MSARSCategory_FK' => 3,
                    'Name' => 'Type 6',
                    'Description' => 'Description 6',
                ],
            ]);
    }
}
