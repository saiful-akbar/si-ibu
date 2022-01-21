<?php

namespace App\Models\Arsip;

use App\Models\Arsip\ARSDocument;
use App\Models\Arsip\MSARSCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSARSType extends Model
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
    protected $table = 'MSARSType';

    /**
     * Primary key
     *
     * @var string
     */
    protected $primaryKey = 'MSARSType_PK';


    /**
     * Kolom yang boleh diisi
     *
     * @var array
     */
    protected $fillable = ['MSARSCategory_FK', 'Nama'];

    /**
     * Relasi belongs to many dengan model MSARSCategory
     *
     * @return object
     */
    public function MSARSCategory(): object
    {
        return $this->belongsTo(MSARSCategory::class, 'MSARSCategory_FK', 'MSARSCategory_PK');
    }

    /**
     * Relasi one to may dengan model MSARSType
     *
     * @return object
     */
    public function ARSDocument(): object
    {
        return $this->hasMany(ARSDocument::class, 'MSARSType_FK', 'MSARSType_PK');
    }
}
