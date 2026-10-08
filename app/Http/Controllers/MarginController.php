<?php
namespace App\Http\Controllers;

use App\Models\{MarginPenjualan, Pengguna};
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class MarginController extends Controller
{
    private array $rules = [
        'persen' => 'required|numeric|min:0|max:100',
        'status' => 'required|in:0,1',
        'iduser' => 'required|exists:user,iduser',
    ];
    private array $fields = ['persen', 'status', 'iduser'];

    public function index() {
        return view('margin.index', ['data' => MarginPenjualan::with('user')->get()]);
    }
    public function create() {
        return view('margin.create', ['user' => Pengguna::all()]);
    }
    public function store(Request $r) {
        $r->validate($this->rules);
        if ($r->status == 1) MarginPenjualan::query()->update(['status' => 0]);
        MarginPenjualan::create($r->only($this->fields));
        return redirect()->route('margin.index')->with('ok', 'Data berhasil ditambahkan');
    }
    public function edit($id) {
        return view('margin.edit', [
            'row'  => MarginPenjualan::findOrFail($id),
            'user' => Pengguna::all(),
        ]);
    }
    public function update(Request $r, $id) {
        $r->validate($this->rules);
        if ($r->status == 1) MarginPenjualan::query()->update(['status' => 0]);
        MarginPenjualan::findOrFail($id)->update($r->only($this->fields));
        return redirect()->route('margin.index')->with('ok', 'Data berhasil diubah');
    }
    public function destroy($id) {
        try {
            MarginPenjualan::findOrFail($id)->delete();
            return back()->with('ok', 'Data berhasil dihapus');
        } catch (QueryException $e) {
            return back()->with('err', 'Data tidak bisa dihapus karena sudah dipakai transaksi');
        }
    }
}
