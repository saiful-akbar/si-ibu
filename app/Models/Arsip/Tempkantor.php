<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tempkantor extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'Tempkantor';
    protected $primaryKey = 'PK';
    protected $guarded = ['PK'];
    protected $fillable = [
        'kantor'
    ];
}
