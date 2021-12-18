<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMenuHeader extends Model
{
    use HasFactory;

    protected $table = 'user_menu_header';
    protected $fillable = ['user_id', 'menu_header_id'];
}
