<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubcripcionController;


Route::get('/subcripcions', [SubcripcionController::class, 'index'])
    ->name('subcripcion.index');

Route::post('/subcripcion/store', [SubcripcionController::class, 'store'])
    ->name('subcripcion.store');

Route::get('/subcripcion/show/{subcripcion}', [SubcripcionController::class, 'show'])
    ->name('subcripcion.show');


