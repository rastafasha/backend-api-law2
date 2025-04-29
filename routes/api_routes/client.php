<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

//Admin Usuarios
Route::get('/clients', [ClienteController::class, 'index'])
    ->name('clients.index');

Route::get('/client/show/{client}', [ClienteController::class, 'clientShow'])
    ->name('client.show');

Route::get('/client/show/ndoc/{n_doc}', [ClienteController::class, 'showNdoc'])
    ->name('client.showNdoc');


Route::put('/client/update/{client}', [ClienteController::class, 'clientUpdate'])
    ->name('client.update');

Route::delete('/client/destroy/{client}', [ClienteController::class, 'clientDestroy'])
    ->name('client.destroy');

Route::get('/client/recientes/', [ClienteController::class, 'recientes'])
    ->name('clients.recientes');

Route::get('/client/search/{request}', [ClienteController::class, 'search'])
    ->name('clients.search');



