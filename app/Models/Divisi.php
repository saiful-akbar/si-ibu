<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $table = 'divisi';
    protected $fillable = [
        'nama_divisi',
    ];

    /**
     * Relasi one to may dengan table user
     */
    public function user()
    {
        return $this->hasMany(User::class, 'divisi_id', 'id');
    }
}
