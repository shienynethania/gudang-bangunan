<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        return view('penjualan.index', [
            'data'   => DB::select('SELECT * FROM v_penjualan ORDER BY idpenjualan DESC'),
            'margin' => DB::selectOne('SELECT persen FROM margin_penjualan WHERE status = 1'),
        ]);
    }

    // nota baru (memakai margin yang sedang aktif dan user yang login), lanjut ke detail
    public function store()
    {
        if (!DB::selectOne('SELECT 1 AS ok FROM margin_penjualan WHERE status = 1')) {
            return back()->with('err', 'Belum ada margin yang aktif. Aktifkan satu margin dulu.');
        }

        try {
            DB::statement('CALL sp_tambah_penjualan(?, @id)', [session('iduser')]);
            $id = DB::selectOne('SELECT @id AS id')->id;
        } catch (QueryException $e) {
            return back()->with('err', $e->errorInfo[2] ?? 'Gagal membuat penjualan');
        }

        return redirect()->route('penjualan.show', $id);
    }

    public function show($id)
    {
        $p = DB::selectOne('SELECT * FROM v_penjualan WHERE idpenjualan = ?', [$id]);
        abort_if(!$p, 404);

        return view('penjualan.show', [
            'p'      => $p,
            'detail' => DB::select('SELECT * FROM v_detail_penjualan WHERE idpenjualan = ?', [$id]),
            'barang' => DB::select('SELECT * FROM v_barang_stok WHERE stok > 0 ORDER BY nama'),
        ]);
    }

    public function tambahDetail(Request $r, $id)
    {
        abort_if(!DB::selectOne('SELECT 1 AS ok FROM penjualan WHERE idpenjualan = ?', [$id]), 404);

        $r->validate([
            'idbarang' => 'required|integer',
            'jumlah'   => 'required|integer|min:1',
        ]);

        // stok dicek di sini karena SP dan trigger tidak memvalidasi
        $b = DB::selectOne('SELECT nama, stok FROM v_barang_stok WHERE idbarang = ?', [$r->idbarang]);
        if (!$b) {
            return back()->withInput()->with('err', 'Barang tidak ditemukan atau tidak aktif');
        }
        if ($r->jumlah > $b->stok) {
            return back()->withInput()->with('err', "Stok {$b->nama} tidak cukup (tersedia {$b->stok})");
        }

        try {
            DB::statement('CALL sp_tambah_detail_penjualan(?, ?, ?)', [$id, $r->idbarang, $r->jumlah]);
        } catch (QueryException $e) {
            return back()->withInput()->with('err', $e->errorInfo[2] ?? 'Gagal menambah barang');
        }

        return redirect()->route('penjualan.show', $id)->with('ok', 'Barang ditambahkan');
    }
}
