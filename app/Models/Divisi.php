<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;

    protected $connection = 'anggaran';
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
     * Relasi one to many dengan tabel budget
     *
     * @return object
     */
    public function budget(): object
    {
        return $this->hasMany(Budget::class, 'divisi_id', 'id');
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
