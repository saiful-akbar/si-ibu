<?php

namespace App\Models;

use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $table = 'budget';
    protected $fillable = [
        'divisi_id',
        'jenis_belanja_id',
        'tahun_anggaran',
        'nominal',
        'keterangan'
    ];

    /**
     * Method relasi one to many dengan table divisi
     *
     * @return object
     */
    public function divisi(): object
    {
        return $this->belongsTo(Divisi::class, 'divisi_id', 'id');
    }

    /**
     * Method relasi one to many dengan table jenis_belanja
     *
     * @return object
     */
    public function jenisBelanja(): object
    {
        return $this->belongsTo(JenisBelanja::class, 'jenis_belanja_id', 'id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'budget_id', 'id');
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
