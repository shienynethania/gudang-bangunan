<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PenerimaanController extends Controller
{
    public function index()
    {
        return view('penerimaan.index', [
            'data' => DB::select('SELECT * FROM v_penerimaan ORDER BY idpenerimaan DESC'),
        ]);
    }

    // langkah 1: pilih pengadaan yang masih pending
    public function create()
    {
        return view('penerimaan.create', [
            'pengadaan' => DB::select("SELECT * FROM v_pengadaan WHERE status = 'P' AND total_nilai > 0 ORDER BY idpengadaan DESC"),
        ]);
    }

    public function store(Request $r)
    {
        $r->validate([
            'idpengadaan' => 'required|integer',
        ]);

        $p = DB::selectOne("SELECT idpengadaan FROM v_pengadaan WHERE idpengadaan = ? AND status = 'P' AND total_nilai > 0", [$r->idpengadaan]);
        if (!$p) {
            return back()->withInput()->with('err', 'Pengadaan tidak ditemukan, sudah tuntas, atau belum punya barang');
        }

        try {
            DB::statement('CALL sp_tambah_penerimaan(?, ?, @id)', [$r->idpengadaan, session('iduser')]);
            $id = DB::selectOne('SELECT @id AS id')->id;
        } catch (QueryException $e) {
            return back()->withInput()->with('err', $e->errorInfo[2] ?? 'Gagal menyimpan data');
        }

        return redirect()->route('penerimaan.show', $id);
    }

    // langkah 2: barang pesanan otomatis muncul, isi jumlah yang diterima (boleh cicil)
    public function show($id)
    {
        $pn = DB::selectOne('SELECT * FROM v_penerimaan WHERE idpenerimaan = ?', [$id]);
        abort_if(!$pn, 404);

        return view('penerimaan.show', [
            'pn'        => $pn,
            'pengadaan' => DB::selectOne('SELECT * FROM v_pengadaan WHERE idpengadaan = ?', [$pn->idpengadaan]),
            'sisa'      => DB::select('SELECT * FROM v_pengadaan_sisa WHERE idpengadaan = ?', [$pn->idpengadaan]),
            'detail'    => DB::select('SELECT * FROM v_detail_penerimaan WHERE idpenerimaan = ?', [$id]),
        ]);
    }

    public function tambahDetail(Request $r, $id)
    {
        $pn = DB::selectOne('SELECT * FROM v_penerimaan WHERE idpenerimaan = ?', [$id]);
        abort_if(!$pn, 404);

        $pg = DB::selectOne('SELECT status FROM v_pengadaan WHERE idpengadaan = ?', [$pn->idpengadaan]);
        if ($pg->status === 'T') {
            return back()->with('err', 'Pengadaan sudah tuntas');
        }

        $input = collect($r->input('jumlah', []))
            ->map(fn ($v) => (int) $v)
            ->filter(fn ($v) => $v > 0);

        if ($input->isEmpty()) {
            return back()->with('err', 'Isi minimal satu jumlah barang yang diterima');
        }

        // jumlah terima tidak boleh melebihi sisa pesanan
        $sisa = collect(DB::select('SELECT idbarang, nama, sisa FROM v_pengadaan_sisa WHERE idpengadaan = ?', [$pn->idpengadaan]))
            ->keyBy('idbarang');

        foreach ($input as $idbarang => $jumlah) {
            if (!isset($sisa[$idbarang])) {
                return back()->with('err', "Barang $idbarang tidak ada di pengadaan ini");
            }
            if ($jumlah > $sisa[$idbarang]->sisa) {
                return back()->with('err', "Jumlah {$sisa[$idbarang]->nama} melebihi sisa pesanan ({$sisa[$idbarang]->sisa})");
            }
        }

        // trigger mengisi kartu stok dan mengubah status jadi TUNTAS bila semua sudah diterima
        try {
            DB::transaction(function () use ($input, $id) {
                foreach ($input as $idbarang => $jumlah) {
                    DB::statement('CALL sp_tambah_detail_penerimaan(?, ?, ?)', [$id, $idbarang, $jumlah]);
                }
            });
        } catch (QueryException $e) {
            return back()->with('err', $e->errorInfo[2] ?? 'Gagal menyimpan penerimaan');
        }

        return redirect()->route('penerimaan.show', $id)->with('ok', 'Penerimaan disimpan');
    }
}
