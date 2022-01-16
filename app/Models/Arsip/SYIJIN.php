<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SYIJIN extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'SYIJIN';
    protected $primaryKey = 'SYIJIN_PK';
    protected $guarded = ['SYIJIN_PK'];
    protected $fillable = [
        'SYLOGIN_FK',
        'SYMODUL_FK',
        'LIHAT',
        'TAMBAH',
        'RUBAH',
        'HAPUS',
        'CETAK',
        'OTORISASI'
    ];
}
