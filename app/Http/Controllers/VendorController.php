<?php
namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    private array $rules = [
        'nama_vendor' => 'required|max:100',
        'badan_hukum' => 'required|in:Y,T',
        'status'      => 'required|in:A,N',
    ];
    private array $fields = ['nama_vendor', 'badan_hukum', 'status'];

    public function index()
    {
        return view('vendor.index', ['data' => DB::select('SELECT * FROM v_vendor_all ORDER BY idvendor')]);
    }
    public function create() { return view('vendor.create'); }

    public function store(Request $r)
    {
        $r->validate([
            'nama_vendor' => 'required',
            'badan_hukum' => 'required',
            'status'      => 'required',
    ]);

    try {
        DB::statement('CALL sp_tambah_vendor(?, ?, ?)', [$r->nama_vendor, $r->badan_hukum, $r->status]);
    } catch (QueryException $e) {
        return back()->withInput()->with('err', $e->errorInfo[2] ?? 'Gagal menyimpan data');
    }

    return redirect()->route('vendor.index')->with('ok', 'Data berhasil ditambahkan');
}

    public function edit($id) { return view('vendor.edit', ['row' => Vendor::findOrFail($id)]); }

    public function update(Request $r, $id) {
        $r->validate($this->rules);
        Vendor::findOrFail($id)->update($r->only($this->fields));
        return redirect()->route('vendor.index')->with('ok', 'Data berhasil diubah');
    }

    public function destroy($id) {
        try {
            Vendor::findOrFail($id)->delete();
            return back()->with('ok', 'Data berhasil dihapus');
        } catch (QueryException $e) {
            return back()->with('err', 'Vendor tidak bisa dihapus karena sudah dipakai pengadaan');
        }
    }
}
