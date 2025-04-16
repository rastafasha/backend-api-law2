<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;


Route::get('favorites', [FavoriteController::class, 'index'])->name('index');
Route::get('/favorites/showbyUser/{user}', [FavoriteController::class, 'favoritesbyUser'])
    ->name('favorites.favoritesbyUser');
Route::get('/favorites/showbyCliente/{cliente}', [FavoriteController::class, 'favoritesbyCliente'])
    ->name('favorites.favoritesbyCliente');
    
Route::get('favorites/show/{id}', [FavoriteController::class, 'show'])->name('favorites.show');
Route::post('favorites/store', [FavoriteController::class, 'store'])->name('favorites.store');
Route::post('favorites/update/{id}', [FavoriteController::class, 'update'])->name('favorites.update');
Route::put('/favorites/update/status/{id}', [FavoriteController::class, 'updateStatus'])
    ->name('favorite.updateStatus');
Route::delete('favorites/destroy/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
