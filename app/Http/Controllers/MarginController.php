<?php
namespace App\Http\Controllers;

use App\Models\MarginPenjualan;
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

    public function index()
    {
        $data = DB::select('SELECT d.*, m.status AS status_angka
                            FROM v_margin_detail d
                            JOIN margin_penjualan m ON m.idmargin_penjualan = d.idmargin_penjualan
                            ORDER BY d.idmargin_penjualan');
        return view('margin.index', ['data' => $data]);
    }

    public function create()
    {
        return view('margin.create', ['user' => DB::select('SELECT * FROM v_user_aman')]);
    }

    public function store(Request $r)
    {
        $r->validate($this->rules);

        try {
            DB::statement('CALL sp_tambah_margin(?, ?, ?)', [$r->persen, (int) $r->status, (int) $r->iduser]);
        } catch (QueryException $e) {
            return back()->withInput()->with('err', $e->errorInfo[2] ?? 'Gagal menyimpan data');
        }

        return redirect()->route('margin.index')->with('ok', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        return view('margin.edit', [
            'row'  => MarginPenjualan::findOrFail($id),
            'user' => DB::select('SELECT * FROM v_user_aman'),
        ]);
    }

    public function update(Request $r, $id)
    {
        $r->validate($this->rules);

        $lama = MarginPenjualan::findOrFail($id);

        // margin aktif tidak boleh dimatikan langsung, harus mengaktifkan margin lain
        if ($lama->status == 1 && (int) $r->status === 0) {
            return back()->withInput()->with('err', 'Margin aktif tidak boleh dinonaktifkan langsung. Aktifkan margin lain.');
        }

        try {
            DB::statement('CALL sp_ubah_margin(?, ?, ?, ?)', [$id, $r->persen, (int) $r->status, (int) $r->iduser]);
        } catch (QueryException $e) {
            return back()->withInput()->with('err', $e->errorInfo[2] ?? 'Gagal mengubah data');
        }

        return redirect()->route('margin.index')->with('ok', 'Data berhasil diubah');
    }

    // tombol Aktifkan: margin ini jadi aktif, yang lain otomatis nonaktif (lewat SP)
    public function aktifkan($id)
    {
        MarginPenjualan::findOrFail($id);
        DB::statement('CALL sp_aktifkan_margin(?)', [$id]);
        return back()->with('ok', 'Margin diaktifkan, margin lain otomatis nonaktif');
    }

    public function destroy($id)
    {
        $m = MarginPenjualan::findOrFail($id);

        if ($m->status == 1) {
            return back()->with('err', 'Margin aktif tidak boleh dihapus. Aktifkan margin lain dulu.');
        }

        try {
            $m->delete();
            return back()->with('ok', 'Data berhasil dihapus');
        } catch (QueryException $e) {
            return back()->with('err', 'Data tidak bisa dihapus karena sudah dipakai transaksi');
        }
    }
}
