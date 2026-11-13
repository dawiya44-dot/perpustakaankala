<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users',
            'password'    => 'required|string|min:6|confirmed',
            'kelas'       => 'nullable|string|max:20',
            'no_wa'       => 'nullable|digits_between:9,15',
            'tempatlahir' => 'nullable|string|max:30',
            'tgllahir'    => 'nullable|date',
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'name.max'           => 'Nama lengkap maksimal 255 karakter.',
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format alamat email tidak valid.',
            'email.unique'       => 'Email ini sudah terdaftar. Silakan gunakan email lain.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal harus 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok. Pastikan kedua password sama.',
            'kelas.max'          => 'Kelas maksimal 20 karakter.',
            'no_wa.digits_between' => 'Nomor WhatsApp hanya boleh angka (9–15 digit).',
            'tempatlahir.max'    => 'Tempat lahir maksimal 30 karakter.',
            'tgllahir.date'      => 'Format tanggal lahir tidak valid.',
        ]);

        // Semua pendaftar baru otomatis mendapatkan role 'user'
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        // Setelah user & anggota terbuat, update data anggota dengan field lengkap dari form
        \App\Models\Anggota::where('nama_anggota', $user->name)
            ->update([
                'kelas'       => $request->kelas       ?: null,
                'no_wa'       => $request->no_wa       ?: null,
                'tempatlahir' => $request->tempatlahir ?: null,
                'tgllahir'    => $request->tgllahir    ?: null,
            ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil! Selamat datang di KalaPustaka.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
