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
                [
                    'Name' => 'Category 1',
                    'Description' => 'Description 1'
                ],
                [
                    'Name' => 'Category 2',
                    'Description' => 'Description 2'
                ],
                [
                    'Name' => 'Category 3',
                    'Description' => 'Description 3'
                ],
            ]);
    }
}
