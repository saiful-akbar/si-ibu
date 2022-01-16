<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSARSDirektorat extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'MSARSDirektorat';
    protected $primaryKey = 'MSARSDirektorat_PK';
    protected $guarded = ['MSARSDirektorat_PK'];
    protected $fillable = [
        'MSARSKantor_FK',
        'Nama'
    ];
}
