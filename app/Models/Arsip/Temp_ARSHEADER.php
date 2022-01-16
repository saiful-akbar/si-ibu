<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temp_ARSHEADER extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'Temp_ARSHEADER';
    protected $primaryKey = 'PKH';
    protected $guarded = ['PKH'];
    protected $fillable = [
        'Satuan_Kerja',
        'Unit_Pengolah',
        'Tgl_Rekam',
        'Kode_Klasifikasi',
        'Nomor_Berkas',
        'Jml_Map',
        'Nomor_Arsip',
        'Uraian_Informasi_Utama',
        'Kurun_Waktu',
        'Retensi_Aktif',
        'Retensi_InAktif',
        'Tingkat_Perkembangan',
        'Lokasi',
        'PIC',
        'Keterangan',
        'Is_Aktif',
        'MSARSKantor_FK',
        'MSARSDirektorat_FK',
        'MSARSPIC_FK'
    ];
}
