<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarginController;

Route::resource('satuan', SatuanController::class)->except('show');
Route::get('/', fn() => redirect('/satuan'));
// route resource ditambah satu per satu di bawah ini
Route::resource('role', RoleController::class)->except('show');
Route::resource('vendor', VendorController::class)->except('show');
Route::resource('barang', BarangController::class)->except('show');
Route::resource('user', UserController::class)->except('show');
Route::resource('margin', MarginController::class)->except('show');

