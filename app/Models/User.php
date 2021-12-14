<?php

namespace App\Models;

use App\Models\Profil;
use App\Models\Role;
use App\Models\Transaksi;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'divisi_id',
        'username',
        'password',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Relasi one to many dengan table role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    /**
     * Relasi one to many dengan table divisi
     */
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id', 'id');
    }

    /**
     * Relasi one to one dengan table profil
     */
    public function profile()
    {
        return $this->hasOne(Profil::class, 'user_id', 'id');
    }

    /**
     * Relasi one to many dengan table transaksi
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'transaksi_id', 'id');
    }
}
