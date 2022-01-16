<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ESELON3 extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'ESELON3';
    protected $primaryKey = 'ESELON3_PK';
    protected $guarded = ['ESELON3_PK'];
    protected $fillable = [
        'ESELON2_FK',
        'NAMA'
    ];
}
