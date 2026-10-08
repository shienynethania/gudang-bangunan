<?php
namespace App\Http\Controllers;

use App\Models\{Pengguna, Role};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function index() {
        return view('user.index', ['data' => Pengguna::with('role')->get()]);
    }
    public function create() {
        return view('user.create', ['role' => Role::all()]);
    }
    public function store(Request $r) {
        $r->validate([
            'username' => 'required|max:45',
            'password' => 'required|min:6',
            'idrole'   => 'required|exists:role,idrole',
        ]);
        Pengguna::create([
            'username' => $r->username,
            'password' => Hash::make($r->password),
            'idrole'   => $r->idrole,
        ]);
        return redirect()->route('user.index')->with('ok', 'Data berhasil ditambahkan');
    }
    public function edit($id) {
        return view('user.edit', ['row' => Pengguna::findOrFail($id), 'role' => Role::all()]);
    }
    public function update(Request $r, $id) {
        $r->validate([
            'username' => 'required|max:45',
            'password' => 'nullable|min:6',
            'idrole'   => 'required|exists:role,idrole',
        ]);
        $data = $r->only('username', 'idrole');
        if ($r->filled('password')) $data['password'] = Hash::make($r->password);
        Pengguna::findOrFail($id)->update($data);
        return redirect()->route('user.index')->with('ok', 'Data berhasil diubah');
    }
    public function destroy($id) {
        try {
            Pengguna::findOrFail($id)->delete();
            return back()->with('ok', 'Data berhasil dihapus');
        } catch (QueryException $e) {
            return back()->with('err', 'Data tidak bisa dihapus karena sudah dipakai transaksi');
        }
    }
}
