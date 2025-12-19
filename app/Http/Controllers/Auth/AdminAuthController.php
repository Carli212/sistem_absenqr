<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLoginAdmin()
    {
        return view('auth.login-admin');
    }

    public function processLoginAdmin(Request $request)
    {
        $request->validate([
            'nomor_wa' => 'required',
            'password' => 'required'
        ]);

        $admin = Admin::where('nomor_wa', $request->nomor_wa)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Login admin gagal');
        }

        // 🔥 PENTING
        $request->session()->invalidate();
        $request->session()->regenerate();

        session([
            'ADMIN_LOGIN' => true,
            'ADMIN_ID'    => $admin->id,
            'ADMIN_NAMA'  => $admin->nama
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function logoutAdmin(Request $request)
    {
        $request->session()->forget([
            'ADMIN_LOGIN',
            'ADMIN_ID',
            'ADMIN_NAMA'
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.admin.show');
    }
}
