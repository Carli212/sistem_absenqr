<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensis'; // pakai sesuai nama tabelmu, kalau 'absensis' atau 'absensis' sesuaikan
    protected $fillable = [
        'user_id',
        'tanggal',
        'waktu_absen',
        'status',
        'metode',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
