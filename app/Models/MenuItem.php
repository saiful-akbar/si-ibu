<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $table = 'menu_item';
    protected $fillable = [
        'menu_header_id',
        'nama_menu',
        'icon',
        'href',
    ];

    /**
     * relasi one to many dengan tabel menu_header
     *
     * @return object
     */
    public function menuHeader()
    {
        return $this->belongsTo(MenuHeader::class, 'menu_header_id', 'id');
    }

    /**
     * relasi many to many dengan tabel user
     *
     * @return object
     */
    public function user()
    {
        return $this->belongsToMany(User::class, 'user_menu_item', 'user_id', 'menu_item_id')
            ->withPivot('create', 'read', 'update', 'delete');
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
