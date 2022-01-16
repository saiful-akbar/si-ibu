<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ESELON4 extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'ESELON4';
    protected $primaryKey = 'ESELON4_PK';
    protected $guarded = ['ESELON4_PK'];
    protected $fillable = [
        'ESELON2_FK',
        'ESELON3_FK',
        'NAMA'
    ];
}
