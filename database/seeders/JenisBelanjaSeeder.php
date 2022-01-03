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
        DB::table('jenis_belanja')->insert([
            [
                'kategori_belanja' => "Barang",
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_belanja' => "Jasa",
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_belanja' => "Orang",
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Method untuk mengambil id divisi (bagian) berdasarkan nama divisisnya (bagiannya)
     *
     * @param string $nama_divisi
     *
     * @return int
     */
    public function getIdDivisi(string $nama_divisi): int
    {
        $divisi = DB::table('divisi')
            ->where('nama_divisi', $nama_divisi)
            ->first();

        return $divisi->id;
    }
}
