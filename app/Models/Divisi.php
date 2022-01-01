<?php

namespace App\Models;

use App\Models\JenisBelanja;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $table = 'divisi';
    protected $fillable = [
        'nama_divisi',
        'active',
    ];

    /**
     * user
     * Relasi one to may dengan table user
     *
     * @return object
     */
    public function user(): object
    {
        return $this->hasMany(User::class, 'divisi_id', 'id');
    }

    /**
     * jenisBelanja
     * Relasi one to many dengan tabel jenis_belanja
     *
     * @return object
     */
    public function jenisBelanja(): object
    {
        return $this->hasMany(JenisBelanja::class, 'divisi_id', 'id');
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
