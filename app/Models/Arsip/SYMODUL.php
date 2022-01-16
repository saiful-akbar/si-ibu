<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SYMODUL extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'SYMODUL';
    protected $primaryKey = 'SYMODUL_PK';
    protected $guarded = ['SYMODUL_PK'];
    protected $fillable = [
        'NAMA',
        'KETERANGAN'
    ];
}
