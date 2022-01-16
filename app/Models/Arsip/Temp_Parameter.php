<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temp_Parameter extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'Temp_Parameter';
    protected $primaryKey = 'Temp_Parameter_PK';
    protected $guarded = ['Temp_Parameter_PK'];
    protected $fillable = [
        'Kantor',
        'Direktorat',
        'PIC',
        'Modul',
        'IjinAkses'
    ];
}
