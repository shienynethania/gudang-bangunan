<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RingkasanController extends Controller
{
    public function index()
    {
        return view('ringkasan.index', [
            'perSatuan'  => DB::table('v_ringkasan_satuan')->get(),
            'diAtasRata' => DB::table('v_barang_di_atas_rata')->get(),
        ]);
    }
}
