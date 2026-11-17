<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class BarangController extends Controller
{
    private array $rules = [
        'jenis'    => 'required|in:S,B,C,P,K',
        'nama'     => 'required|max:45',
        'idsatuan' => 'required|exists:satuan,idsatuan',
        'status'   => 'required|in:0,1',
        'harga'    => 'required|integer|min:0',
    ];

    private array $fields = ['jenis', 'nama', 'idsatuan', 'status', 'harga'];

    // VIEW TAMPIL
    public function index(Request $r)
    {
        $filter = $r->query('filter', 'semua');
        $view   = $filter === 'aktif' ? 'v_barang_aktif' : 'v_barang_all';

        $data = DB::select("SELECT * FROM $view ORDER BY idbarang");

        return view('barang.index', compact('data', 'filter'));
    }

    // VIEW DROPDOWN SATUAN
    public function create()
    {
        return view('barang.create', [
            'satuan' => DB::select('SELECT * FROM v_satuan_aktif'),
        ]);
    }

    // SIMPAN BARANG STO                                                                                                                RED PROCEDURE
    public function store(Request $r)
    {
        $r->validate([
            'jenis'    => 'required',
            'nama'     => 'required',
            'idsatuan' => 'required',
            'status'   => 'required',
            'harga'    => 'required',
        ]);

        try {
            DB::statement('CALL sp_tambah_barang(?, ?, ?, ?, ?)', [
                $r->jenis, $r->nama, (int) $r->idsatuan, (int) $r->harga, (int) $r->status,
            ]);
        } catch (QueryException $e) {
            return back()->withInput()->with('err', $e->errorInfo[2] ?? 'Gagal menyimpan data');
        }

        return redirect()->route('barang.index')->with('ok', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $row = Barang::findOrFail($id);

        $satuan = Satuan::where('status', 1)
            ->orWhere('idsatuan', $row->idsatuan)
            ->get();

        return view('barang.edit', ['row' => $row, 'satuan' => $satuan]);
    }

    public function update(Request $r, $id)
    {
        $r->validate($this->rules);
        Barang::findOrFail($id)->update($r->only($this->fields));
        return redirect()->route('barang.index')->with('ok', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        try {
            Barang::findOrFail($id)->delete();
            return back()->with('ok', 'Data berhasil dihapus');
        } catch (QueryException $e) {
            return back()->with('err', 'Barang tidak bisa dihapus karena sudah dipakai transaksi');
        }
    }
}
