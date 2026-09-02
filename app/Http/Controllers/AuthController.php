<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman Login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Menampilkan halaman Register
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses Register
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => [
                'required',
                'string',
                'max:100',
                'unique:users,username'
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed'
            ],

            'role' => [
                'nullable',
                'string',
                'in:SUPERADMIN,ADMIN,ENGINEER,SUPERVISOR,MANAGER'
            ],

            'permissions' => [
                'nullable',
                'array'
            ],
        ]);

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),

            'role' => $request->input('role', 'ENGINEER'),

            'permissions' => $request->input(
                'permissions',
                ['dashboard']
            ),
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Registrasi berhasil.');
    }

    /**
     * Proses Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = $request->input('username');

        /*
        |--------------------------------------------------------------------------
        | Cek apakah input berupa email atau username
        |--------------------------------------------------------------------------
        */

        $fieldType = filter_var(
            $loginInput,
            FILTER_VALIDATE_EMAIL
        )
            ? 'email'
            : 'username';

        $credentials = [
            $fieldType => $loginInput,
            'password' => $request->input('password'),
        ];

        /*
        |--------------------------------------------------------------------------
        | LOGIN GAGAL
        |--------------------------------------------------------------------------
        |
        | Jika username/email atau password salah,
        | langsung tampilkan halaman 403 custom.
        |
        */

        if (!Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {
            abort(
                403,
                'Username/Email atau password yang Anda masukkan salah.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN BERHASIL
        |--------------------------------------------------------------------------
        */

        $request->session()->regenerate();

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | SUPERADMIN
        |--------------------------------------------------------------------------
        |
        | Superadmin diarahkan terlebih dahulu ke halaman
        | pemilihan role.
        |
        */

        if (strtoupper($user->role) === 'SUPERADMIN') {
            return redirect()->route('select-role');
        }

        /*
        |--------------------------------------------------------------------------
        | USER BIASA
        |--------------------------------------------------------------------------
        */

        return redirect()->intended(
            route('dashboard')
        );
    }

    /**
     * Halaman pemilihan role Superadmin
     */
    public function selectRole()
    {
        /*
        |--------------------------------------------------------------------------
        | Hanya SUPERADMIN
        |--------------------------------------------------------------------------
        */

        if (
            !Auth::check() ||
            strtoupper(Auth::user()->role) !== 'SUPERADMIN'
        ) {
            return redirect()->route('dashboard');
        }

        return view('auth.select-role');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Dashboard
     */
    public function dashboard(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Mengambil role aktif
        |--------------------------------------------------------------------------
        */

        $activeRole = $request->query(
            'switch_role',
            Auth::user()->role
        );

        return view('dashboard.index', [
            'user' => Auth::user(),
            'activeRole' => strtoupper($activeRole),
        ]);
    }
}