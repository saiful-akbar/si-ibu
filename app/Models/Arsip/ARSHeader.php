<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ARSHeader extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'ARSHeader';
    protected $primaryKey = 'ARSHeader_PK';
    protected $guarded = ['ARSHeader_PK'];
    protected $fillable = [
        'MSARSKantor_FK',
        'MSARSDirektorat_FK',
        'NomorBox',
        'NomorRak',
        'TglInput',
        'KodeKlasifikasi',
        'UraianInformasi',
        'KurunWaktu',
        'TingkatPerkembangan',
        'Jumlah',
        'Lokasi',
        'MSARSPic_FK',
        'Keterangan',
        'Is_Aktif',
        'Retensi1',
        'Retensi2'
    ];
}
