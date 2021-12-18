<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMenuItem extends Model
{
    use HasFactory;

    protected $table = 'user_menu_item';
    protected $fillable = [
        'user_id',
        'menu_item_id',
        'create',
        'read',
        'update',
        'delete'
    ];
}
