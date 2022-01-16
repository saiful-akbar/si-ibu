<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ARSPeminjamanStatus extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'ARSPeminjamanStatus';
    protected $primaryKey = 'ARSPeminjamanStatus_PK';
    protected $guarded = ['ARSPeminjamanStatus_PK'];
    protected $fillable = [
        'NomorBAST',
        'Tanggal',
        'Dig_Dokumen'
    ];
}
