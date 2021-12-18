<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuHeader extends Model
{
    use HasFactory;

    protected $table = 'menu_header';
    protected $filabale = ['nama_header'];

    /**
     * Relasi many to many dengan tabel user
     */
    public function user()
    {
        return $this->belongsToMany(User::class, 'user_menu_header', 'user_id', 'menu_header_id')
            ->withPivot('read');
    }

    /**
     * relasi one to many dengan tabel menu_item
     * @return [type]
     */
    public function menuItem()
    {
        return $this->hasMany(MenuItem::class, 'menu_header_id', 'id');
    }
}
