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
            'role'        => ['nullable', 'string', 'in:SUPERADMIN,ADMIN,ENGINEER,SUPERVISOR,MANAGER'],
            'permissions' => ['nullable', 'array'],
        ]);

        $user = User::create([
            'username'    => $data['username'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'role'        => $request->input('role', 'ENGINEER'),
            'permissions' => $request->input('permissions', ['dashboard']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil.');
    }

   public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string', 
            'password' => 'required|string'
        ]);

        $loginInput = $request->input('username');
        $fieldType  = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $loginInput,
            'password'  => $request->input('password'),
        ];

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['username' => 'Username/Email atau password salah.'])
                ->withInput($request->only('username'));
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Redireksi Khusus Superadmin
        if (strtoupper($user->role) === 'SUPERADMIN') {
            return redirect()->route('select-role');
        }

        return redirect()->intended(route('dashboard'));
    }

    // Tambahkan method ini untuk menampilkan view portal pilihan role
    public function selectRole()
    {
        // Memastikan hanya SUPERADMIN yang bisa mengakses halaman ini
        if (strtoupper(Auth::user()->role) !== 'SUPERADMIN') {
            return redirect()->route('dashboard');
        }

        return view('auth.select-role');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function dashboard(Request $request)
    {
        // Mengambil role aktif (jika superadmin memilih switch_role dari portal)
        $activeRole = $request->query('switch_role', Auth::user()->role);

        // Ubah 'dashboard' menjadi 'dashboard.index'
        return view('dashboard.index', [
            'user'       => Auth::user(),
            'activeRole' => strtoupper($activeRole)
        ]);
    }
}