<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
Route::resource('movies', MovieController::class);
Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');