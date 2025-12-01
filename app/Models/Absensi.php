<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis'; // ganti jika table mu berbeda
    protected $fillable = [
        'user_id', 'tanggal', 'waktu_absen', 'status', 'metode', 'ip_address'
    ];

    protected $casts = [
        'waktu_absen' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
