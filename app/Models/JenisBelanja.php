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
