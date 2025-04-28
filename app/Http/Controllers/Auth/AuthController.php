<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function index()
    {
        return view('auth.index');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        // Pastikan tidak ada session lama
        Auth::logout();
    
        // Coba ambil user dari database
        $user = \App\Models\User::where('email', $credentials['email'])->first();
    
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar.',
            ])->onlyInput('email');
        }
    
        // Cek password
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah.',
            ])->onlyInput('email');
        }
    
        // Login
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();
    
        // Redirect sesuai role
        if ($user->role_id == 1) {
            return redirect()->route('admin.dashboard');
        }
    
        return redirect()->intended(route('chat'));
    }
    
    public function register(Request $request, $role_id = 2)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buat user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $role_id,
        ]);

        // Login otomatis
        Auth::login($user);
        $request->session()->regenerate();

        // Redirect ke halaman chat
        return redirect()->route('chat');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
