<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarginController;
use App\Http\Controllers\RingkasanController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\KartuStokController;

Route::get('kartu-stok', [KartuStokController::class, 'index'])->name('kartustok.index');

Route::resource('penjualan', PenjualanController::class)->only(['index', 'store', 'show']);
Route::post('penjualan/{id}/detail', [PenjualanController::class, 'tambahDetail'])->name('penjualan.detail');

Route::resource('penerimaan', PenerimaanController::class)->only(['index', 'create', 'store', 'show']);
Route::post('penerimaan/{id}/detail', [PenerimaanController::class, 'tambahDetail'])->name('penerimaan.detail');

Route::resource('pengadaan', PengadaanController::class)->only(['index', 'create', 'store', 'show']);
Route::post('pengadaan/{id}/detail', [PengadaanController::class, 'tambahDetail'])->name('pengadaan.detail');

Route::resource('satuan', SatuanController::class)->except('show');
Route::get('/', fn() => redirect('/satuan'));
// route resource ditambah satu per satu di bawah ini
Route::resource('role', RoleController::class)->except('show');
Route::resource('vendor', VendorController::class)->except('show');
Route::resource('barang', BarangController::class)->except('show');
Route::resource('user', UserController::class)->except('show');
Route::resource('margin', MarginController::class)->except('show');
Route::post('margin/{id}/aktif', [MarginController::class, 'aktifkan'])->name('margin.aktif');
Route::get('ringkasan', [RingkasanController::class, 'index'])->name('ringkasan.index');

