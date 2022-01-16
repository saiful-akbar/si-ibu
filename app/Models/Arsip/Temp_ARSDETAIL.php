<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temp_ARSDETAIL extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'Temp_ARSDETAIL';
    protected $primaryKey = 'PKH';
    protected $guarded = ['PKH'];
    protected $fillable = [
        'Tgl_Rekam',
        'No_Berkas',
        'TglNaskahDinas',
        'KodeKlasifikasi',
        'Tgl_Dokumen',
        'Uraian_Informasi_Detail',
        'Jml_Arsip',
        'Keterangan',
        'PIC',
        'Status_Dok',
        'Status_Pinjam',
        'Status_Musnah'
    ];
}
