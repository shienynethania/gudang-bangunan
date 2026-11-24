<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, SatuanController, RoleController, VendorController, BarangController,
    UserController, MarginController, RingkasanController, PengadaanController,
    PenerimaanController, PenjualanController, KartuStokController
};
use App\Http\Middleware\{CekLogin, CekRole};

// ---------- TAMU ----------
Route::get('login', [AuthController::class, 'formLogin'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.proses');
Route::get('register', [AuthController::class, 'formRegister'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.proses');

// ---------- HARUS LOGIN ----------
Route::middleware(CekLogin::class)->group(function () {

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // halaman awal sesuai role
    Route::get('/', function () {
        return match ((int) session('idrole')) {
            4       => redirect()->route('penjualan.index'),
            3       => redirect()->route('pengadaan.index'),
            default => redirect()->route('ringkasan.index'),
        };
    });

    // 1 = Super Admin, 2 = Admin Gudang, 3 = Staf Pengadaan, 4 = Kasir

    // --- Super Admin saja ---
    Route::middleware(CekRole::class . ':1')->group(function () {
        Route::resource('user', UserController::class)->except('show');
        Route::resource('role', RoleController::class)->except('show');
        Route::resource('margin', MarginController::class)->except('show');
        Route::post('margin/{id}/aktif', [MarginController::class, 'aktifkan'])->name('margin.aktif');
    });

    // --- Satuan: kelola 1,2 | lihat 1,2,3 ---
    Route::resource('satuan', SatuanController::class)->except(['show', 'index'])->middleware(CekRole::class . ':1,2');
    Route::resource('satuan', SatuanController::class)->only('index')->middleware(CekRole::class . ':1,2,3');

    // --- Barang: kelola 1,2 | lihat 1,2,3,4 ---
    Route::resource('barang', BarangController::class)->except(['show', 'index'])->middleware(CekRole::class . ':1,2');
    Route::resource('barang', BarangController::class)->only('index')->middleware(CekRole::class . ':1,2,3,4');

    // --- Vendor: kelola 1,3 | lihat 1,2,3 ---
    Route::resource('vendor', VendorController::class)->except(['show', 'index'])->middleware(CekRole::class . ':1,3');
    Route::resource('vendor', VendorController::class)->only('index')->middleware(CekRole::class . ':1,2,3');

    // --- Pengadaan: buat 1,3 | lihat 1,2,3 (create didaftar dulu sebelum show) ---
    Route::resource('pengadaan', PengadaanController::class)->only(['create', 'store'])->middleware(CekRole::class . ':1,3');
    Route::post('pengadaan/{id}/detail', [PengadaanController::class, 'tambahDetail'])->name('pengadaan.detail')->middleware(CekRole::class . ':1,3');
    Route::resource('pengadaan', PengadaanController::class)->only(['index', 'show'])->middleware(CekRole::class . ':1,2,3');

    // --- Penerimaan: buat 1,2 | lihat 1,2,3 ---
    Route::resource('penerimaan', PenerimaanController::class)->only(['create', 'store'])->middleware(CekRole::class . ':1,2');
    Route::post('penerimaan/{id}/detail', [PenerimaanController::class, 'tambahDetail'])->name('penerimaan.detail')->middleware(CekRole::class . ':1,2');
    Route::resource('penerimaan', PenerimaanController::class)->only(['index', 'show'])->middleware(CekRole::class . ':1,2,3');

    // --- Penjualan: 1,4 ---
    Route::middleware(CekRole::class . ':1,4')->group(function () {
        Route::resource('penjualan', PenjualanController::class)->only(['index', 'store', 'show']);
        Route::post('penjualan/{id}/detail', [PenjualanController::class, 'tambahDetail'])->name('penjualan.detail');
    });

    // --- Kartu Stok & Ringkasan: 1,2 ---
    Route::middleware(CekRole::class . ':1,2')->group(function () {
        Route::get('kartu-stok', [KartuStokController::class, 'index'])->name('kartustok.index');
        Route::get('ringkasan', [RingkasanController::class, 'index'])->name('ringkasan.index');
    });
});
