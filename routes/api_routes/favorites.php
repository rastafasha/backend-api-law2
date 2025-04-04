<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoritesController;

Route::get('/favorites', [FavoritesController::class, 'index'])
    ->name('favorite.index');

Route::get('/favorite/show/{favorite}', [FavoritesController::class, 'show'])
    ->name('favorite.show');

    Route::get('/favorite/showbyuser/{user}', [FavoritesController::class, 'favoriteByUser'])
    ->name('favorite.favoriteByUser');

Route::get('/favorite/recientes', [FavoritesController::class, 'recientes'])
    ->name('favorite.recientes');

Route::get('/favorite/destacados', [FavoritesController::class, 'destacados'])
    ->name('favorite.destacados');

Route::post('/favorite/store', [FavoritesController::class, 'favoriteStore'])
    ->name('favorite.store');

Route::put('/favorite/update/{favorite}', [FavoritesController::class, 'favoriteUpdate'])
    ->name('favorite.update');

Route::put('/favorite/update/status/{favorite:id}', [FavoritesController::class, 'favoriteUpdateStatus'])
    ->name('favorite.status');

Route::get('/favorite/search/', [FavoritesController::class, 'search'])
    ->name('favorite.search');

Route::delete('/favorite/destroy/{favorite}', [FavoritesController::class, 'destroy'])
    ->name('favorite.destroy');