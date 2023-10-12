<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TvController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActorsController;
use App\Http\Controllers\MoviesController;
use App\Http\Controllers\MyListMoviesController;


Route::get('/', [MoviesController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MoviesController::class, 'show'])->name('movies.show');

Route::get('/tv', [TvController::class, 'index'])->name('tv.index');
Route::get('/tv/{id}', [TvController::class, 'show'])->name('tv.show');

Route::get('/actors', [ActorsController::class, 'index'])->name('actors.index');
Route::get('/actors/page/{page?}', [ActorsController::class, 'index']);

Route::get('/mylist', [MyListMoviesController::class, 'index'])->name('mylist.index');
Route::get('/mylist/{id}', [MyListMoviesController::class, 'show'])->name('mylist.show');
Route::post('/movies', [MyListMoviesController::class, 'store'])->name('movies.store');
Route::delete('/mylist/{id}', [MyListMoviesController::class, 'destroy'])->name('mylist.destroy');