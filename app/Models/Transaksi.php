<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'transaksi';
    protected $fillable = [
        'user_id',
        'budget_id',
        'tanggal',
        'kegiatan',
        'jumlah_nominal',
        'no_dokumen',
        'file_dokumen',
        'uraian',
        'approval',
    ];

    /**
     * Method relasi one to many dengan table user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Method relasi one to many dengan table jenis_belanja
     */
    public function budget()
    {
        return $this->belongsTo(budget::class, 'budget_id', 'id');
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
