<?php
namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class SatuanController extends Controller
{
    private array $rules = [
        'nama_satuan' => 'required|max:45',
        'status'      => 'required|in:0,1',
    ];

    public function index()  { return view('satuan.index', ['data' => Satuan::all()]); }
    public function create() { return view('satuan.create'); }

    public function store(Request $r) {
        $r->validate($this->rules);
        Satuan::create($r->only('nama_satuan', 'status'));
        return redirect()->route('satuan.index')->with('ok', 'Data berhasil ditambahkan');
    }

    public function edit($id) { return view('satuan.edit', ['row' => Satuan::findOrFail($id)]); }

    public function update(Request $r, $id) {
        $r->validate($this->rules);
        Satuan::findOrFail($id)->update($r->only('nama_satuan', 'status'));
        return redirect()->route('satuan.index')->with('ok', 'Data berhasil diubah');
    }

    public function destroy($id) {
        try {
            Satuan::findOrFail($id)->delete();
            return back()->with('ok', 'Data berhasil dihapus');
        } catch (QueryException $e) {
            return back()->with('err', 'Data tidak bisa dihapus karena masih dipakai tabel lain');
        }
    }
}
