<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'password',
        'tanggal_lahir',
        'ip_address',
        
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * RELATION: user -> absensis
     */
    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'user_id');
    }
}
