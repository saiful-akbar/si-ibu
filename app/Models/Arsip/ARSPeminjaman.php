<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ARSPeminjaman extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'ARSPeminjaman';
    protected $primaryKey = 'ARSPeminjaman_PK';
    protected $guarded = ['ARSPeminjaman_PK'];
    protected $fillable = [
        'MSARSKantor_FK',
        'MSARSDirektorat_FK',
        'ARSHeader_FK',
        'ARSDetail_FK',
        'StatusDok',
        'AsalPeminjam',
        'TanggalInput',
        'TanggalPinjam',
        'TanggalKembali',
        'NIP',
        'Nama',
        'Pangkat',
        'Jabatan',
        'Unit',
        'Alasan',
        'NomorBAST',
        'Status2',
        'NomorNDPersetujuan',
        'NomorNDPermohonan'
    ];
}
