<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * insert table user
         */
        DB::connection('anggaran')
            ->table('user')
            ->insert([
                [
                    'divisi_id' => 1,
                    'username' => 'admin',
                    'password' => bcrypt('admin1234'),
                    'seksi' => 'Administrator',
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'divisi_id' => 2,
                    'username' => 'staff',
                    'password' => bcrypt('staff1234'),
                    'seksi' => 'staff',
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);

        /**
         * insert table profil
         */
        DB::connection('anggaran')
            ->table('profil')
            ->insert([
                [
                    'user_id' => 1,
                    'avatar' => null,
                    'nama_lengkap' => 'Administrator',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => 2,
                    'avatar' => null,
                    'nama_lengkap' => 'Staff',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);

        /**
         * insert table pengaturan
         */
        DB::connection('anggaran')
            ->table('pengaturan')
            ->insert([
                [
                    'user_id' => 1,
                    'tema' => 'dark',
                    'sidebar' => 'dark',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => 2,
                    'tema' => 'light',
                    'sidebar' => 'light',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
    }
}
