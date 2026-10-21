<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Satuan;
use App\Models\VBarangDetail;
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

    // Menampilkan data dari VIEW v_barang_detail
    public function index()
    {
        return view('barang.index', [
            'data' => VBarangDetail::orderBy('idbarang')->get(),
        ]);
    }

    // Dropdown satuan diambil dari VIEW v_satuan_aktif
    public function create()
    {
        return view('barang.create', [
            'satuan' => DB::table('v_satuan_aktif')->get(),
        ]);
    }

    // Simpan, ubah, hapus tetap ke tabel asli
    public function store(Request $r)
    {
        $r->validate($this->rules);
        Barang::create($r->only($this->fields));
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
