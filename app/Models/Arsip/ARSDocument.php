<?php

namespace App\Models\Arsip;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ARSDocument extends Model
{
    use HasFactory;

    /**
     * Koneksi database
     *
     * @var string
     */
    protected $connection = 'arsip';

    /**
     * Nama tabel
     *
     * @var string
     */
    protected $table = 'ARSDocument';

    /**
     * Primary key
     *
     * @var string
     */
    protected $primaryKey = 'ARSDocument_PK';

    /**
     * Kolom yang boleh diisi
     *
     * @var array
     */
    protected $fillable = [
        'MSARSCategory_FK',
        'MSARSType_FK',
        'DateDoc',
        'Number',
        'Dokumen',
        'NamaFile',
        'DateAdds',
        'Years',
        'Is_Publish',
    ];

    /**
     * Relasi one to many (inverse) dengan model MSARSType
     *
     * @return object
     */
    public function MSARSType(): object
    {
        return $this->belongsTo(MSARSType::class, 'MSARSType_FK', 'MSARSType_PK');
    }
}
