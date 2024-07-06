<?php

use App\Http\Controllers\PeliculasController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
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


Route::resource('posts', PeliculasController::class);
Route::resource('categories', CategoryController::class);

Route::get('/dashboard', [PeliculasController::class, 'index'])->name('dashboard');
Route::get('/', [PeliculasController::class, 'lista'])->name('welcome');


Route::get('/peliculas', [PeliculasController::class, 'lista'])->name('peliculas.lista');
Route::get('/peliculas/{id}', [PeliculasController::class, 'show'])->name('peliculas.show');

Route::get('/Categorias', function () {
    return view('Categorias');
})->middleware(['auth', 'verified'])->name('Categorias');




Route::get('/email/verify', [App\Http\Controllers\Auth\EmailVerificationPromptController::class, '__invoke'])->middleware(['auth', 'throttle:6,1'])->name('verification.notice');

require __DIR__.'/auth.php';