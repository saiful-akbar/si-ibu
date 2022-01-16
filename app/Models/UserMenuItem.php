<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMenuItem extends Model
{
    use HasFactory;

    protected $connection = 'sqlsrv';
    protected $table = 'user_menu_item';
    protected $fillable = [
        'user_id',
        'menu_item_id',
        'create',
        'read',
        'update',
        'delete'
    ];

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
