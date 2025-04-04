<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

Route::get('/documents', [DocumentController::class, 'index'])
    ->name('document.index');

Route::get('/document/show/{document}', [DocumentController::class, 'show'])
    ->name('document.show');
Route::get('/document/showbyuser/{user}', [DocumentController::class, 'documentByUser'])
    ->name('document.documentByUser');

Route::get('/document/recientes', [DocumentController::class, 'recientes'])
    ->name('document.recientes');

Route::get('/document/destacados', [DocumentController::class, 'destacados'])
    ->name('document.destacados');

Route::post('/document/store', [DocumentController::class, 'documentStore'])
    ->name('document.store');

Route::put('/document/update/{document}', [DocumentController::class, 'documentUpdate'])
    ->name('document.update');

Route::put('/document/update/status/{document:id}', [DocumentController::class, 'documentUpdateStatus'])
    ->name('document.status');

Route::get('/document/search/', [DocumentController::class, 'search'])
    ->name('document.search');

Route::delete('/document/destroy/{document}', [DocumentController::class, 'destroy'])
    ->name('document.destroy');