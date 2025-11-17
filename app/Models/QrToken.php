<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrToken extends Model
{
    protected $fillable = ['token','expired_at','status'];

    protected $casts = [
        'expired_at' => 'datetime',
    ];
}
