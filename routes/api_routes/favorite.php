<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;


Route::get('favorites', [FavoriteController::class, 'index'])->name('index');
Route::get('/favorites/showbyUser/{user}', [FavoriteController::class, 'favoritesbyUser'])
    ->name('favorites.favoritesbyUser');
Route::get('/favorites/showbyCliente/{cliente}', [FavoriteController::class, 'favoritesbyCliente'])
    ->name('favorites.favoritesbyCliente');
Route::get('favorites/profile/{id}', [FavoriteController::class, 'profile'])->name('profile');
Route::get('favorites/show/{id}', [FavoriteController::class, 'show'])->name('show');
Route::post('favorites/store', [FavoriteController::class, 'store'])->name('store');
Route::post('favorites/update/{id}', [FavoriteController::class, 'update'])->name('update');
Route::put('/favorites/update/status/{id}', [FavoriteController::class, 'updateStatus'])
    ->name('favorite.updateStatus');
Route::delete('favorites/destroy/{id}', [FavoriteController::class, 'destroy'])->name('destroy');
