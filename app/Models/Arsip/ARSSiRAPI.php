<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ARSSiRAPI extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv2';
    protected $table = 'ARSSiRAPI';
    protected $primaryKey = 'ARSSiRAPI_PK';
    protected $guarded = ['ARSSiRAPI_PK'];
    protected $fillable = [
        'MSARSKantor_FK',
        'MSARSPic_FK',
        'Tahun',
        'Semester',
        'Ruangan',
        'Jml_Ruangan',
        'RuanganKhusus',
        'Jml_RuanganKhusus',
        'Luas_RuanganKhusus',
        'Gedung',
        'File_Gedung',
        'Jml_Gedung',
        'Luas_Gedung',
        'Jml_RakInaktif',
        'File_RAK',
        'TimKearsipan',
        'NomorTIM',
        'File_Tim',
        'KondisiArsip',
        'Jml_Anggaran_Belanja',
        'Jml_Anggaran_Penataan',
        'Jml_Arsip_Inaktif_Subtantif',
        'Jml_Arsip_SiapMusnah_Subtantif',
        'Jml_Arsip_Inaktif_Fasilitatif',
        'Jml_Arsip_SiapMusnah_Fasilitatif'
    ];
}
