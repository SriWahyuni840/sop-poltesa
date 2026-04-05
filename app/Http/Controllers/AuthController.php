<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function prosesLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('users')
            ->where('username', $request->username)
            ->first();

        if (!$user) {
            return back()->with('error', 'Username tidak ditemukan.');
        }

        if ($request->password !== $user->password) {
            return back()->with('error', 'Password salah.');
        }

        Session::put('user_id', $user->id);
        Session::put('name', $user->name);
        Session::put('role', $user->role);
        Session::put('unit_id', $user->unit_id);

        if ($user->role === 'unit') {
            return redirect()->route('unit.dashboard');
        }

        if ($user->role === 'admin_p2mpp') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'kepala_pusat') {
            return redirect()->route('kepala.dashboard');
        }

        if ($user->role === 'bagian_umum') {
            return redirect()->route('umum.dashboard');
        }

        if ($user->role === 'direktur') {
            return redirect()->route('direktur.dashboard');
        }

        return back()->with('error', 'Role tidak dikenali.');
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}