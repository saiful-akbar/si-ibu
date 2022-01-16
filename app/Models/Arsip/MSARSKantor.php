<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSARSKantor extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'MSARSKantor';
    protected $primaryKey = 'MSARSKantor_PK';
    protected $guarded = ['MSARSKantor_PK'];
    protected $fillable = [
        'Nama',
        'Header1',
        'Header2',
        'Header3'
    ];
}
