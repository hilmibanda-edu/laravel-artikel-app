<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtikelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Halaman Utama (Bisa dilihat siapa saja tanpa login)
Route::get('/artikel', [ArtikelController::class, 'index']);

// Group Route yang Wajib Login
Route::middleware(['auth'])->group(function () {
    Route::get('/artikel/tambah', [ArtikelController::class, 'create']);
    Route::post('/artikel/simpan', [ArtikelController::class, 'store']);
    Route::get('/artikel/{id}/edit', [ArtikelController::class, 'edit']);
    Route::put('/artikel/{id}', [ArtikelController::class, 'update']);
    Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy']);
});

require __DIR__.'/auth.php';
