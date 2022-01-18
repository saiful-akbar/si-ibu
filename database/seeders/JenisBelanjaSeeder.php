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
        DB::connection('anggaran')
            ->table('jenis_belanja')->insert([
                [
                    'akun_belanja_id' => $this->getIdAkunBelanja('Barang'),
                    'kategori_belanja' => "Pengadaan pembelian barang",
                    'active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
    }

    /**
     * Method untuk mengambil id (akun_belanja) berdasarkan nama akun belanjanya
     *
     * @param string $namaAkunBelanja
     *
     * @return int
     */
    public function getIdAkunBelanja(string $namaAkunBelanja): int
    {
        $divisi = DB::connection('anggaran')
            ->table('akun_belanja')
            ->where('nama_akun_belanja', $namaAkunBelanja)
            ->first();

        return $divisi->id;
    }
}
