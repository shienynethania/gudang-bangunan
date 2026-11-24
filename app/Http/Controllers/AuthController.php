<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    // Super Admin (1) sengaja tidak bisa dipilih saat registrasi
    private array $roleDaftar = [2, 3, 4];

    public function formLogin()
    {
        if (session()->has('iduser')) return redirect('/');
        return view('auth.login');
    }

    public function login(Request $r)
    {
        $r->validate(['username' => 'required', 'password' => 'required']);

        $u = Pengguna::where('username', $r->username)->first();

        if (!$u || !$this->cekPassword($r->password, $u->password)) {
            return back()->withInput($r->only('username'))->with('err', 'Username atau password salah');
        }

        $r->session()->regenerate();
        session([
            'iduser'    => $u->iduser,
            'username'  => $u->username,
            'idrole'    => $u->idrole,
            'nama_role' => DB::table('role')->where('idrole', $u->idrole)->value('nama_role'),
        ]);

        return redirect('/');
    }

    public function formRegister()
    {
        if (session()->has('iduser')) return redirect('/');
        return view('auth.register', [
            'role' => DB::table('role')->whereIn('idrole', $this->roleDaftar)->get(),
        ]);
    }

    public function register(Request $r)
    {
        $r->validate([
            'username' => 'required|max:45|unique:user,username',
            'password' => 'required|min:6|confirmed',
            'idrole'   => ['required', Rule::in($this->roleDaftar)],
        ]);

        Pengguna::create([
            'username' => $r->username,
            'password' => Hash::make($r->password),
            'idrole'   => $r->idrole,
        ]);

        return redirect()->route('login')->with('ok', 'Registrasi berhasil, silakan login');
    }

    public function logout(Request $r)
    {
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return redirect()->route('login')->with('ok', 'Anda sudah keluar');
    }

    // mendukung password bcrypt (dari aplikasi) dan SHA2-256 (akun contoh dari SQL)
    private function cekPassword(string $input, string $tersimpan): bool
    {
        if (str_starts_with($tersimpan, '$2y$')) {
            return Hash::check($input, $tersimpan);
        }
        return hash_equals($tersimpan, hash('sha256', $input));
    }
}
