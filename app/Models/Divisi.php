<?php

namespace App\Models;

use App\Models\Transaksi;
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

    /**
     * Method relasi one to many dengan table budget
     */
    public function budget()
    {
        return $this->hasMany(Budget::class, 'divisi_id', 'id');
    }

    /**
     * Relasi one to many dengan table transaksi
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'transaksi_id', 'id');
    }
}
