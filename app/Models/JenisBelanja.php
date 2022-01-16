<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBelanja extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'jenis_belanja';
    protected $fillable = [
        'akun_belanja_id',
        'kategori_belanja',
        'active',
    ];

    /**
     * Relasi one to many dengan tabel budget
     *
     * @return object
     */
    public function budget(): object
    {
        return $this->hasMany(Budget::class, 'jenis_belanja_id', 'id');
    }

    /**
     * Relasi one to many dengan table akun_belanja
     *
     * @return object
     */
    public function akunBelanja(): object
    {
        return $this->belongsTo(AkunBelanja::class, 'akun_belanja_id', 'id');
    }

    /**
     * Merubah format created_at
     */
    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])->format('d M Y H:i');
    }

    /**
     * Merubah format updated_at
     */
    public function getUpdatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['updated_at'])->format('d M Y H:i');
    }
}
