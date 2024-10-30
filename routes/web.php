<?php

use App\Http\Controllers\ObatController;
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