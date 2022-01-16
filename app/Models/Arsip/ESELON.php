<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ESELON extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'ESELON';
    protected $primaryKey = 'ESELON2_FK';
    protected $guarded = ['ESELON2_FK'];
    protected $fillable = [
        'ESELON3_FK',
        'NAMAES2',
        'NAMAES3',
        'NAMAES4'
    ];
}
