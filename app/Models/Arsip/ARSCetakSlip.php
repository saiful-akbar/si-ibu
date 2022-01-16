<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ARSCetakSlip extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'ARSCetakSlip';
    protected $primaryKey = 'ARSCetakSlip_PK';
    protected $guarded = ['ARSCetakSlip_PK'];
    protected $fillable = [
        'NIP',
        'Nama',
        'UnitKerja',
        'NomorBerkas',
        'Perihal',
        'KodeBox',
        'TglPeminjaman',
        'TglKembali',
        'SYLogin_FK'
    ];
}
