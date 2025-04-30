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

Route::get('/client/clientes-user/{user}', [ClienteController::class, 'clientesByUser'])
    ->name('client.clientesByUser');

Route::get('/client/contactos-cliente/{client}', [ClienteController::class, 'contactosByClient'])
    ->name('/client.contactosByClient');

Route::post('/client/addClienttoUser/{user}', [ClienteController::class, 'addClienttoUser'])
    ->name('client.addClienttoUser');

Route::delete('/client/removeClientFromUser/{client}', [ClienteController::class, 'removeClientFromUser'])
    ->name('client.removeClientFromUser');

