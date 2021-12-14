<?php

namespace App\Models;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillabale = [
        'user_id',
        'divisi_id',
        'kegiatan',
        'jumlah',
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
     * Method relasi one to many dengan table divisi
     */
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id', 'id');
    }
}
