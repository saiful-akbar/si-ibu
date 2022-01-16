<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSARSPic extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'MSARSPic';
    protected $primaryKey = 'MSARSPic_PK';
    protected $guarded = ['MSARSPic_PK'];
    protected $fillable = [
        'MSARSKantor_FK',
        'MSARSDirektorat_FK',
        'Nama'
    ];
}
