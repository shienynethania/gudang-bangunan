<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RingkasanController extends Controller
{
    public function index()
    {
        $stok = DB::table('v_stok_barang')->orderBy('stok')->orderBy('nama')->get();

        return view('ringkasan.index', [
            'stok'                => $stok,
            'jmlHabis'            => $stok->where('status_stok', 'HABIS')->count(),
            'jmlMenipis'          => $stok->where('status_stok', 'MENIPIS')->count(),
            'pesanan'             => DB::table('v_pesanan_pending')->orderBy('idpengadaan')->orderBy('nama_barang')->get(),
            'jmlPengadaanPending' => DB::table('pengadaan')->where('status', 'P')->count(),
            'harian'              => DB::table('v_transaksi_harian')->orderByDesc('tanggal')->limit(7)->get(),
            'hariIni'             => DB::table('v_transaksi_harian')->whereRaw('tanggal = CURDATE()')->first(),
        ]);
    }
}
