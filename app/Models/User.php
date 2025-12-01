<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'password',
        'tanggal_lahir',
        'ip_address',
        'foto',
    ];

    protected $hidden = [
        'password'
    ];
}
