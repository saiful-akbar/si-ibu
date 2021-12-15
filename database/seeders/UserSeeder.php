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
        DB::table('user')->insert([
            [
                'role_id' => 1,
                'divisi_id' => 1,
                'username' => 'admin',
                'password' => bcrypt('admin1234'),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => 2,
                'divisi_id' => 2,
                'username' => 'staf',
                'password' => bcrypt('staf1234'),
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('profil')->insert([
            [
                'user_id' => 1,
                'avatar' => 'avatar_default.webp',
                'nama_lengkap' => 'Administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'avatar' => 'avatar_default.webp',
                'nama_lengkap' => 'Staff',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
