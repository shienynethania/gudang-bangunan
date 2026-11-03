<?php
namespace App\Http\Controllers;

use App\Models\{MarginPenjualan, Pengguna};
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class MarginController extends Controller
{
    private array $rules = [
        'persen' => 'required|numeric|min:0|max:100',
        'status' => 'required|in:0,1',
        'iduser' => 'required|exists:user,iduser',
    ];
    private array $fields = ['persen', 'status', 'iduser'];

    public function index()
    {
        return view('margin.index', ['data' => DB::select('SELECT * FROM v_margin_detail ORDER BY idmargin_penjualan')]);
    }
    public function create() {
        return view('margin.create', ['user' => DB::select('SELECT * FROM v_user_aman')]);
    }
    public function store(Request $r)
    {
        $r->validate([
            'persen' => 'required|numeric',
            'status' => 'required|in:0,1',
            'iduser' => 'required|integer',
    ]);

        try {
            DB::statement('CALL sp_tambah_margin(?, ?, ?)', [$r->persen, (int) $r->status, (int) $r->iduser]);
        } catch (QueryException $e) {
            return back()->withInput()->with('err', $e->errorInfo[2] ?? 'Gagal menyimpan data');
        }

        return redirect()->route('margin.index')->with('ok', 'Data berhasil ditambahkan');
    }
    public function edit($id) {
        return view('margin.edit', [
            'row'  => MarginPenjualan::findOrFail($id),
            'user' => DB::select('SELECT * FROM v_user_aman'),
        ]);
    }
    public function update(Request $r, $id)
    {
        $r->validate([
            'persen' => 'required|numeric',
            'status' => 'required|in:0,1',
            'iduser' => 'required|integer',
    ]);

    try {
        DB::statement('CALL sp_ubah_margin(?, ?, ?, ?)', [$id, $r->persen, (int) $r->status, (int) $r->iduser]);
    } catch (QueryException $e) {
        return back()->withInput()->with('err', $e->errorInfo[2] ?? 'Gagal mengubah data');
    }

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
