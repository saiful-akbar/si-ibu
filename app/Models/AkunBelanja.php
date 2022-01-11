<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunBelanja extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'akun_belanja';
    protected $fillable = ['id', 'nama_akun_belanja', 'active'];

    /**
     * Relasi one to many denga tabel jenis_belanja
     *
     * @return object
     */
    public function jenisBelanja(): object
    {
        return $this->hasMany(JenisBelanja::class, 'akun_belanja_id', 'id');
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
