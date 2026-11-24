<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;

class BarangController extends Controller
{
    private array $fields = ['jenis', 'nama', 'idsatuan', 'status', 'harga', 'idvendor'];

    private array $messages = [
        'jenis.in'          => 'Jenis barang tidak valid',
        'nama.required'     => 'Nama barang wajib diisi',
        'nama.unique'       => 'Nama barang sudah ada',
        'harga.min'         => 'Harga tidak boleh negatif',
        'idsatuan.exists'   => 'Satuan tidak ditemukan atau tidak aktif',
        'idvendor.required' => 'Vendor wajib dipilih',
        'idvendor.exists'   => 'Vendor tidak ditemukan',
    ];

    // aturan validasi; $ignoreId dipakai saat ubah supaya nama sendiri tidak dianggap duplikat
    private function rules($ignoreId = null): array
    {
        $unik = Rule::unique('barang', 'nama');
        if ($ignoreId) {
            $unik->ignore($ignoreId, 'idbarang');
        }

        return [
            'jenis'    => 'required|in:S,B,C,P,K',
            'nama'     => ['required', 'max:45', $unik],
            'idsatuan' => ['required', 'integer', Rule::exists('satuan', 'idsatuan')->where('status', 1)],
            'status'   => 'required|in:0,1',
            'harga'    => 'required|integer|min:0',
            'idvendor' => ['required', 'integer', Rule::exists('vendor', 'idvendor')],
        ];
    }

    // VIEW TAMPIL
    public function index(Request $r)
    {
        $filter = $r->query('filter', 'semua');
        $view   = $filter === 'aktif' ? 'v_barang_aktif' : 'v_barang_all';

        // view lama belum punya kolom vendor, jadi digabung lewat tabel barang
        $data = DB::select(
            "SELECT x.*, v.nama_vendor
             FROM $view x
             JOIN barang b ON b.idbarang = x.idbarang
             LEFT JOIN vendor v ON v.idvendor = b.idvendor
             ORDER BY x.idbarang"
        );

        return view('barang.index', compact('data', 'filter'));
    }

    // VIEW DROPDOWN SATUAN + VENDOR
    public function create()
    {
        return view('barang.create', [
            'satuan' => DB::select('SELECT * FROM v_satuan_aktif'),
            'vendor' => DB::select("SELECT idvendor, nama_vendor FROM vendor WHERE status = 'A' ORDER BY nama_vendor"),
        ]);
    }

    // SIMPAN BARANG STORED PROCEDURE
    public function store(Request $r)
    {
        $r->merge(['nama' => trim($r->nama)]);
        $r->validate($this->rules(), $this->messages);

        try {
            DB::statement('CALL sp_tambah_barang(?, ?, ?, ?, ?, ?)', [
                $r->jenis, $r->nama, (int) $r->idsatuan, (int) $r->harga, (int) $r->status, (int) $r->idvendor,
            ]);
        } catch (QueryException $e) {
            return back()->withInput()->with('err', $e->errorInfo[2] ?? 'Gagal menyimpan data');
        }

        return redirect()->route('barang.index')->with('ok', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $row = Barang::findOrFail($id);

        $satuan = DB::select(
            'SELECT * FROM satuan WHERE status = 1 OR idsatuan = ?', [$row->idsatuan]
        );

        // vendor aktif + vendor barang ini (walau sudah nonaktif)
        $vendor = DB::select(
            "SELECT idvendor, nama_vendor FROM vendor WHERE status = 'A' OR idvendor = ? ORDER BY nama_vendor",
            [$row->idvendor]
        );

        return view('barang.edit', ['row' => $row, 'satuan' => $satuan, 'vendor' => $vendor]);
    }

    public function update(Request $r, $id)
    {
        $r->merge(['nama' => trim($r->nama)]);
        $r->validate($this->rules($id), $this->messages);

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
