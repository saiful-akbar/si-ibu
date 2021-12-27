<?php

namespace App\Models;

use App\Models\MenuHeader;
use App\Models\MenuItem;
use App\Models\Profil;
use App\Models\Transaksi;
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
        'divisi_id',
        'username',
        'password',
        'seksi',
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
     * Relasi one to many dengan table divisi
     */
    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id', 'id');
    }

    /**
     * Relasi one to one dengan table profil
     */
    public function profil()
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

    /**
     * Relasi many to many dengan tabel menu_header
     */
    public function menuHeader()
    {
        return $this->belongsToMany(MenuHeader::class, 'user_menu_header', 'user_id', 'menu_header_id')
            ->withPivot('read');
    }

    /**
     * relasi many to many dengan tabel menu_item
     *
     * @return object
     */
    public function menuItem()
    {
        return $this->belongsToMany(MenuItem::class, 'user_menu_item', 'user_id', 'menu_item_id')
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
