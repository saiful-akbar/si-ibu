<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SYLOGIN extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'SYLOGIN';
    protected $primaryKey = 'SYLOGIN_PK';
    protected $guarded = ['SYLOGIN_PK'];
    protected $fillable = [
        'MSARSKantor_FK',
        'MSARSDirektorat_FK',
        'MSARSPic_FK',
        'LOGINNAME',
        'PASSWORD',
        'LASTLOGIN',
        'LOGINCOUNT'
    ];
}
