<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'ip_address',
        'foto',        // 🟢 WAJIB ADA
    ];

    // Jangan pakai date cast, karena format kamu dd/mm/yyyy → string saja
    protected $casts = [
        'tanggal_lahir' => 'string'
    ];
}