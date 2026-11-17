<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PengadaanController extends Controller
{
    public function index()
    {
        return view('pengadaan.index', [
            'data' => DB::select('SELECT * FROM v_pengadaan ORDER BY idpengadaan DESC'),
        ]);
    }

    // langkah 1: pilih vendor + user
    public function create()
    {
        return view('pengadaan.create', [
            'vendor' => DB::select("SELECT idvendor, nama_vendor FROM vendor WHERE status = 'A' ORDER BY nama_vendor"),
            'user'   => DB::select('SELECT * FROM v_user_aman'),
        ]);
    }

    // tombol Next: SP membuat kepala pengadaan, lanjut ke detail
    public function store(Request $r)
    {
        $r->validate([
            'idvendor' => ['required', 'integer', Rule::exists('vendor', 'idvendor')->where('status', 'A')],
            'iduser'   => 'required|exists:user,iduser',
        ]);

        try {
            DB::statement('CALL sp_tambah_pengadaan(?, ?, @id)', [$r->iduser, $r->idvendor]);
            $id = DB::selectOne('SELECT @id AS id')->id;
        } catch (QueryException $e) {
            return back()->withInput()->with('err', $e->errorInfo[2] ?? 'Gagal menyimpan data');
        }

        return redirect()->route('pengadaan.show', $id);
    }

    // langkah 2: detail pengadaan
    public function show($id)
    {
        $p = DB::selectOne('SELECT * FROM v_pengadaan WHERE idpengadaan = ?', [$id]);
        abort_if(!$p, 404);

        return view('pengadaan.show', [
            'p'      => $p,
            'detail' => DB::select('SELECT * FROM v_detail_pengadaan WHERE idpengadaan = ?', [$id]),
            // harga yang tampil = harga terakhir beli barang itu dari vendor ini
            'barang' => DB::select(
                'SELECT b.idbarang, b.nama, s.nama_satuan, fn_harga_beli_terakhir(?, b.idbarang) AS harga
                 FROM barang b JOIN satuan s ON b.idsatuan = s.idsatuan
                 WHERE b.status = 1 ORDER BY b.nama',
                [$p->idvendor]
            ),
        ]);
    }

    public function tambahDetail(Request $r, $id)
    {
        $p = DB::selectOne('SELECT status FROM v_pengadaan WHERE idpengadaan = ?', [$id]);
        abort_if(!$p, 404);

        if ($p->status === 'T') {
            return back()->with('err', 'Pengadaan sudah tuntas, tidak bisa menambah barang');
        }

        $r->validate([
            'idbarang' => ['required', 'integer', Rule::exists('barang', 'idbarang')->where('status', 1)],
            'jumlah'   => 'required|integer|min:1',
        ]);

        try {
            DB::statement('CALL sp_tambah_detail_pengadaan(?, ?, ?)', [$id, $r->idbarang, $r->jumlah]);
        } catch (QueryException $e) {
            return back()->withInput()->with('err', $e->errorInfo[2] ?? 'Gagal menambah barang');
        }

        return redirect()->route('pengadaan.show', $id)->with('ok', 'Barang ditambahkan');
    }
}
