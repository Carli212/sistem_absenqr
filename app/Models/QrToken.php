<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'expired_at',
        'status',
    ];

    protected $dates = [
        'expired_at',
    ];
}
