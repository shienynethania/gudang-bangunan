<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KartuStokController extends Controller
{
    public function index(Request $r)
    {
        $q = DB::table('v_kartu_stok')->orderBy('idbarang')->orderBy('idkartu_stok');

        // filter per barang (opsional)
        if ($r->filled('idbarang')) {
            $q->where('idbarang', (int) $r->idbarang);
        }

        return view('kartustok.index', [
            'data'     => $q->get(),
            'barang'   => DB::table('barang')->where('status', 1)->orderBy('nama')->get(['idbarang', 'nama']),
            'idbarang' => $r->idbarang,
        ]);
    }
}
