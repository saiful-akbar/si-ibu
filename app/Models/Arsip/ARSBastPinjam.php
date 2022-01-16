<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ARSBastPinjam extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'ARSBastPinjam';
    protected $primaryKey = 'ARSBastPinjam_PK';
    protected $guarded = ['ARSBastPinjam_PK'];
    protected $fillable = [
        'NomorBAST',
        'Dig_Dokumen',
    ];
}
