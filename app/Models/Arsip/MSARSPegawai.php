<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSARSPegawai extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'MSARSPegawai';
    protected $primaryKey = 'MSARSPegawai_PK';
    protected $guarded = ['MSARSPegawai_PK'];
    protected $fillable = [
        'ESELON2',
        'ESELON3',
        'NIP',
        'NAMA',
        'PANGKAT',
        'JABATAN',
        'NIPNAMA'
    ];
}
