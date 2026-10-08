<?php
namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class RoleController extends Controller
{
    private array $rules = [
        'nama_role' => 'required|max:100',
    ];

    public function index()  { return view('role.index', ['data' => Role::all()]); }
    public function create() { return view('role.create'); }

    public function store(Request $r) {
        $r->validate($this->rules);
        Role::create($r->only('nama_role'));
        return redirect()->route('role.index')->with('ok', 'Data berhasil ditambahkan');
    }

    public function edit($id) { return view('role.edit', ['row' => Role::findOrFail($id)]); }

    public function update(Request $r, $id) {
        $r->validate($this->rules);
        Role::findOrFail($id)->update($r->only('nama_role'));
        return redirect()->route('role.index')->with('ok', 'Data berhasil diubah');
    }

    public function destroy($id) {
        try {
            Role::findOrFail($id)->delete();
            return back()->with('ok', 'Data berhasil dihapus');
        } catch (QueryException $e) {
            return back()->with('err', 'Role tidak bisa dihapus karena masih dipakai user');
        }
    }
}
