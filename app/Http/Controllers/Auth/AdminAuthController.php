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
            'nama' => 'required|string',
            'nomor_wa' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('nama', $request->nama)
                        ->where('nomor_wa', $request->nomor_wa)
                        ->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withInput()->with('error', 'Data login tidak valid.');
        }

        session([
            'admin_id'   => $admin->id,
            'admin_name' => $admin->nama,
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function logoutAdmin()
    {
        session()->forget(['admin_id', 'admin_name']);
        return redirect()->route('login.admin.show');
    }
}
