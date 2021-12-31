<?php

namespace App\Models;

use App\Models\Divisi;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class JenisBelanja extends Model
{
    use HasFactory;

    protected $table = 'jenis_belanja';
    protected $fillable = [
        'kategori_belanja',
        'divisi_id',
        'active',
    ];

    /**
     * Relasi onr to many dengan tabel transaksi
     *
     * @return object
     */
    public function transaksi(): object
    {
        return $this->hasMany(Transaksi::class, 'jenis_belanja_id', 'id');
    }

    /**
     * divisi
     * Relasi one to many dengan tabel dvisi
     *
     * @return object
     */
    public function divisi(): object
    {
        return $this->belongsTo(Divisi::class, 'divisi_id', 'id');
    }

    /**
     * Relasi one to many dengan tabel budget
     *
     * @return object
     */
    public function budget(): object
    {
        return $this->hasMany(Budget::class, 'jenis_belanja_id', 'id');
    }
}
