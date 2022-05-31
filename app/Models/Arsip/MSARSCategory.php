<?php

namespace App\Models\Arsip;

use App\Models\Arsip\MSARSType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSARSCategory extends Model
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
    protected $table = 'MSARSCategory';

    /**
     * Primary key
     *
     * @var string
     */
    protected $primaryKey = 'MSARSCategory_PK';

    /**
     * Kolom yang boleh diisi
     *
     * @var array
     */
    protected $fillable = ['Nama', 'Description'];

    /**
     * Relasi one to many dengan model MSARSType
     *
     * @return object
     */
    public function MSARSType(): object
    {
        return $this->hasMany(MSARSType::class, 'MSARSCategory_FK', 'MSARSCategory_PK');
    }
}
