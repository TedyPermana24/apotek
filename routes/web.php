<?php

use App\Http\Controllers\ObatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PembelianObatController;
use App\Http\Controllers\PenjualanObatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/home');
});
Route::get('/home', function () {
    return view('home', ['type_menu' => 'dashboard']);
});

Route::get('/obat', [ObatController::class, 'tampil', ])->name('obat.tampil');
Route::post('/obat/add', [ObatController::class, 'add', ])->name('obat.add');
Route::get('/obat/edit/{id}', [ObatController::class, 'edit', ])->name('obat.edit');
Route::post('/obat/update/{id}', [ObatController::class, 'update', ])->name('obat.update');
Route::post('/obat/delete/{id}', [ObatController::class, 'delete', ])->name('obat.delete');

Route::get('/kategori', [KategoriController::class, 'tampil', ])->name('kategori.tampil');
Route::post('/kategori/add', [KategoriController::class, 'add', ])->name('kategori.add');
Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit', ])->name('kategori.edit');
Route::post('/kategori/update/{id}', [KategoriController::class, 'update', ])->name('kategori.update');
Route::post('/kategori/delete/{id}', [KategoriController::class, 'delete', ])->name('kategori.delete');

Route::get('/unit', [UnitController::class, 'tampil', ])->name('unit.tampil');
Route::post('/unit/add', [UnitController::class, 'add', ])->name('unit.add');
Route::get('/unit/edit/{id}', [UnitController::class, 'edit', ])->name('unit.edit');
Route::post('/unit/update/{id}', [UnitController::class, 'update', ])->name('unit.update');
Route::post('/unit/delete/{id}', [UnitController::class, 'delete', ])->name('unit.delete');

Route::get('/pemasok', [PemasokController::class, 'tampil', ])->name('pemasok.tampil');
Route::post('/pemasok/add', [PemasokController::class, 'add', ])->name('pemasok.add');
Route::get('/pemasok/edit/{id}', [PemasokController::class, 'edit', ])->name('pemasok.edit');
Route::post('/pemasok/update/{id}', [PemasokController::class, 'update', ])->name('pemasok.update');
Route::post('/pemasok/delete/{id}', [PemasokController::class, 'delete', ])->name('pemasok.delete');

Route::get('/pembelian', [PembelianController::class, 'tampil', ])->name('pembelian.tampil');
Route::post('/pembelian/store', [PembelianController::class, 'store'])->name('pembelian.store');
Route::post('/pembelian/delete/{id}', [PembelianController::class, 'delete'])->name('pembelian.delete');
Route::get('/pembelian/edit/{id}', [PembelianController::class, 'edit'])->name('pembelian.edit');
Route::post('/pembelian/update/{id}', [PembelianController::class, 'update'])->name('pembelian.update');

Route::get('/detailpembelian', [PembelianObatController::class, 'tampil', ])->name('detailpembelian.tampil');

Route::get('/detailpembelian/showDetail/{id}', [PembelianObatController::class, 'detail', ])->name('detailpembelian.detail');

Route::get('/detailpenjualan', [penjualanObatController::class, 'tampil', ])->name('detailpenjualan.tampil');
Route::get('/detailpenjualan/showDetail/{id}', [PenjualanObatController::class, 'detail', ])->name('detailpenjualan.detail');
Route::get('/penjualan', [PenjualanController::class, 'tampil', ])->name('penjualan.tampil');
Route::post('/penjualan/store', [PenjualanController::class, 'store'])->name('penjualan.store');
Route::post('/penjualan/delete/{id}', [PenjualanController::class, 'delete'])->name('penjualan.delete');
Route::get('/penjualan/edit/{id}', [PenjualanController::class, 'edit'])->name('penjualan.edit');
Route::post('/penjualan/update/{id}', [PenjualanController::class, 'update'])->name('penjualan.update');



// Route::get('/default', function () {
//     return view('pages.default.default', ['type_menu' => 'dashboard']);
// });

// Route::get('/error-403', function () {
//     return view('pages.errors.error-403', ['type_menu' => 'error']);
// });
// Route::get('/error-404', function () {
//     return view('pages.errors.error-404', ['type_menu' => 'error']);
// });
// Route::get('/error-500', function () {
//     return view('pages.errors.error-500', ['type_menu' => 'error']);
// });
// Route::get('/error-503', function () {
//     return view('pages.errors.error-503', ['type_menu' => 'error']);
// });