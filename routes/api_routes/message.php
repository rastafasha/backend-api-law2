<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;


Route::get('/messages', [MessageController::class, 'index'])
    ->name('message.index');

Route::get('message/show/{id}', [MessageController::class, 'show'])
    ->name('message.show');

    
Route::get('message/user/{user_id}/{client_id}', [MessageController::class, 'getByUser'])
    ->name('message.getByUser');

Route::get('message/cliente/{client_id}/{user_id}', [MessageController::class, 'getByCliente'])
    ->name('message.getByCliente');

Route::post('message/store', [MessageController::class, 'storeMessage'])
    ->name('message.storeMessage');


