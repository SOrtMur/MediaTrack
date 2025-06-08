<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\YourMovieController;
use App\Http\Controllers\YourGameController;
use App\Http\Controllers\YourMangaController;
use App\Http\Controllers\YourAnimeController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/library', function () {
    return view('library');
});

Route::get('/search', function () {
    return view('search');
})->name('search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('usuario', UserController::class)->names('user');
Route::resource('pelicula', MovieController::class)->names('movie');
Route::resource('anime', AnimeController::class)->names('anime');
Route::resource('manga', MangaController::class)->names('manga');
Route::resource('juego', GameController::class)->names('game');
Route::resource('tu_pelicula', YourMovieController::class)->names('your_movie');
Route::resource('tu_juego', YourGameController::class)->names('your_game');
Route::resource('tu_manga', YourMangaController::class)->names('your_manga');
Route::resource('tu_anime', YourAnimeController::class)->names('your_anime');

Route::post('tmdb', [APIController::class, 'TMDBSearch'])->name('tmdb.index');

Route::get('tmdb/{id}', [APIController::class, 'TMDBShow'])->name('tmdb.show');

require __DIR__.'/auth.php';