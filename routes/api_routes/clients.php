<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;

//Admin Usuarios
Route::get('/clients', [ClienteController::class, 'index'])
    ->name('clients.index');

Route::get('/clients/show/{client}', [ClienteController::class, 'clientShow'])
    ->name('clients.show');

Route::get('/clients/show/ndoc/{n_doc}', [ClienteController::class, 'showNdoc'])
    ->name('clients.showNdoc');


Route::put('/clients/update/{client}', [ClienteController::class, 'clientUpdate'])
    ->name('clients.update');

Route::delete('/clients/destroy/{client}', [ClienteController::class, 'clientDestroy'])
    ->name('clients.destroy');

Route::get('/clients/recientes/', [ClienteController::class, 'recientes'])
    ->name('clients.recientes');

Route::get('/clients/search/{request}', [ClienteController::class, 'search'])
    ->name('clients.search');

Route::get('/clients/clientes-user/{user}', [ClienteController::class, 'clientesByUser'])
    ->name('clients.clientesByUser');

Route::get('/clients/contactos-cliente/{client}', [ClienteController::class, 'contactosByClient'])
    ->name('/clients.contactosByClient');

Route::post('/clients/addClienttoUser/', [ClienteController::class, 'addClienttoUser'])
    ->name('clients.addClienttoUser');

Route::delete('/clients/removeClientFromUser/{user_id}/{client_id}/', [ClienteController::class, 'removeClientFromUser'])
    ->name('clients.removeClientFromUser');

