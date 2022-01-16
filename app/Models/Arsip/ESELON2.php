<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ESELON2 extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'ESELON2';
    protected $primaryKey = 'ESELON2_PK';
    protected $guarded = ['ESELON2_PK'];
    protected $fillable = [
        'NAMA',
    ];
}
