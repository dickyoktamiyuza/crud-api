<?php

use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('buku', [BukuController::class, 'index'])->name('buku.index'); // Menampilkan daftar buku
Route::post('buku', [BukuController::class, 'store'])->name('buku.store'); // Menyimpan buku baru
Route::delete('buku/{id}', [BukuController::class, 'destroy'])->name('buku.destroy'); // Menghapus buku
Route::get('buku/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');
Route::put('buku/{id}', [BukuController::class, 'update'])->name('buku.update');
