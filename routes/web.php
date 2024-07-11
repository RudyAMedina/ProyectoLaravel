<?php

use App\Http\Controllers\PeliculasController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        // Obtener el usuario autenticado
        $user = auth()->user();

        if ($user->hasRole('administrador')) {
            // si el usuario es administrador, muestra el dashboard de películas
            return app(PeliculasController::class)->index();
        } else {
            // si no es administrador, muestra el userdashboard
            $userId = $user->id;
            return app(CommentController::class)->index($userId);
        }
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::resource('posts', PeliculasController::class);
Route::resource('categories', CategoryController::class);

//Route::get('/dashboard', [PeliculasController::class, 'index'])->name('dashboard');
Route::get('/', [PeliculasController::class, 'lista'])->name('welcome');

Route::get('/peliculas', [PeliculasController::class, 'lista'])->name('peliculas.lista');

Route::get('/peliculas/{id}', [PeliculasController::class, 'show'])->name('peliculas.show');

Route::get('/Categorias', function () {
    return view('Categorias');
})->middleware(['auth', 'verified'])->name('Categorias');

//Ruta para manejar las calificaciones de las peliculas
Route::middleware('auth')->group(function () {
    Route::post('/rate', [RatingController::class, 'store'])->name('rate');
    });

//ruta para pasar el id del usuario
Route::middleware(['auth'])->group(function () {
    Route::get('/calificaciones', function () {
        $user = auth()->user();
        $userId = $user->id;
        return app(RatingController::class)->index($userId);
    })->name('calificaciones.index');
});

Route::delete('/calificaciones/{rating}', [RatingController::class, 'destroy'])->name('calificaciones.destroy');

Route::patch('/calificaciones/{id}', [RatingController::class, 'update'])->name('calificaciones.update');

//ruta para manejar los comentarios de las peliculas
Route::middleware('auth')->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('comentarios.destroy');

Route::patch('/{id}', [CommentController::class, 'update'])->name('comentarios.update');

require __DIR__.'/auth.php';
