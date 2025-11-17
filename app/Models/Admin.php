<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'password',
        'nomor_wa',
        'tanggal_lahir',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];
}
