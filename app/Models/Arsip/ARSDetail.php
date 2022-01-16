<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ARSDetail extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'ARSDetail';
    protected $primaryKey = 'ARSDetail_PK';
    protected $guarded = ['ARSDetail_PK'];
    protected $fillable = [
        'ARSHeader_FK',
        'TglInput',
        'KodeKlasifikasi',
        'UraianInformasi',
        'NomorBerkas',
        'TglNaskahDinas',
        'TglDokumen',
        'Jumlah',
        'MSARSPic_FK',
        'Keterangan',
        'Dig_Dokumen',
        'Status1',
        'Status2',
        'Status3'
    ];
}
