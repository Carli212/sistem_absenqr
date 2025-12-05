<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        if (!session('siswa_id')) {
            return redirect()->route('login.siswa.show');
        }

        $user = User::find(session('siswa_id'));
        $foto = $user && $user->foto && file_exists(public_path('uploads/' . $user->foto))
            ? asset('uploads/' . $user->foto)
            : asset('default-avatar.png');


        return view('profile.index', compact('user', 'foto'));
    }
}
