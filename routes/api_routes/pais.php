<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaisController;

Route::get('paises', [PaisController::class, 'index'])->name('pais.index');
Route::get('pais/countryList/', [PaisController::class, 'countriesCode'])->name('pais.countriesCode');
Route::get('pais/show/{id}', [PaisController::class, 'show'])->name('pais.show');
Route::get('pais/code/{code}', [PaisController::class, 'showCode'])->name('pais.showCode');

Route::get('pais/search/{request}', [PaisController::class, 'search'])
    ->name('pais.search');

Route::post('pais/store', [PaisController::class, 'store'])->name('pais.store');
Route::post('pais/update/{pais}', [PaisController::class, 'update'])->name('pais.update');
Route::delete('pais/destroy/{id}', [PaisController::class, 'destroy'])->name('pais.destroy');

Route::options('/{any}', function (Request $request) {
    return response()->json(['status' => 'OK']);
    })->where('any', '.*');
