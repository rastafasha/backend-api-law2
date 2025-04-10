<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudesController;


Route::get('/solicitudes', [SolicitudesController::class, 'index'])
    ->name('solicitud.index');

Route::get('solicitud/show/{id}', [SolicitudesController::class, 'show'])
    ->name('solicitud.show');

Route::get('solicitud/clientes-user/{id}', [SolicitudesController::class, 'clientesByUser'])
    ->name('solicitud.clientesByUser');

    
Route::get('solicitud/user/{user_id}', [SolicitudesController::class, 'getByUser'])
    ->name('solicitud.getByUser');

Route::post('solicitud/store', [SolicitudesController::class, 'store'])
    ->name('solicitud.store');

Route::put('solicitud/update/{solicitud}', [SolicitudesController::class, 'update'])
    ->name('solicitud.update');

Route::put('solicitud/update-status/{solicitud}', [SolicitudesController::class, 'updateStatusSolicitud'])
    ->name('solicitud.updateStatusSolicitud');


Route::delete('solicitud/destroy/{solicitud}', [SolicitudesController::class, 'destroy'])
    ->name('solicitud.destroy');
