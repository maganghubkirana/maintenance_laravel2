<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    public function register(Request $request)
    {
        $data = $request->validate([
            'username'    => ['required', 'string', 'max:100', 'unique:users,username'],
            'email'       => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'    => ['required', 'string', 'min:6', 'confirmed'],
            // Tambahkan validasi untuk role & permissions
            'role'        => ['nullable', 'string', 'in:SUPERADMIN,ADMIN,ENGINEER,SUPERVISOR,MANAGER'],
            'permissions' => ['nullable', 'array'],
        ]);

        $user = User::create([
            'username'    => $data['username'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            // Set role pilihan (atau fallback default ke ENGINEER/USER jika kosong)
            'role'        => $request->input('role', 'ENGINEER'),
            // Set hak akses pilihan (atau fallback default akses ke dashboard saja)
            'permissions' => $request->input('permissions', ['dashboard']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string', 
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['username' => 'Username atau password salah.'])->withInput($request->only('username'));
        }

        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}