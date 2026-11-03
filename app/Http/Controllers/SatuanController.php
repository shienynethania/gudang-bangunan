<?php
namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class SatuanController extends Controller
{
    private array $rules = [
        'nama_satuan' => 'required|max:45',
        'status'      => 'required|in:0,1',
    ];

   public function index()
    {
        return view('satuan.index', ['data' => DB::select('SELECT * FROM v_satuan_all ORDER BY idsatuan')]);
    }
    public function create() { return view('satuan.create'); }

    public function store(Request $r)
    {
        $r->validate([
            'nama_satuan' => 'required',
            'status'      => 'required|in:0,1',
    ]);

    try {
        DB::statement('CALL sp_tambah_satuan(?, ?)', [$r->nama_satuan, (int) $r->status]);
    } catch (QueryException $e) {
        return back()->withInput()->with('err', $e->errorInfo[2] ?? 'Gagal menyimpan data');
    }

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
