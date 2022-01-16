<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temp_Dashboard extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'Temp_Dashboard';
    protected $primaryKey = 'Temp_Dashboard_PK';
    protected $guarded = ['Temp_Dashboard_PK'];
    protected $fillable = [
        'Catat_Berkas',
        'Catat_IsiBerkas',
        'Catat_FileDigital',
        'Pinjam_Berkas',
        'Pinjam_IsiBerkas',
        'Pinjam_FileDigital'
    ];
}
