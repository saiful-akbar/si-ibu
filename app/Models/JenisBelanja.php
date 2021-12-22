<?php

namespace App\Models;

use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBelanja extends Model
{
    use HasFactory;

    protected $table = 'jenis_belanja';
    protected $fillable = ['kategori_belanja'];

    /**
     * Relasi onr to many dengan tabel transaksi
     *
     * @return object
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'jenis_belanja_id', 'id');
    }
}
