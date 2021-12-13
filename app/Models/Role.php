<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';
    protected $fillable = ['level'];

    /**
     * Relasi one to many dengan tabel user
     */
    public function user()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
