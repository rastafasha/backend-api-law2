<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SolicitudesController;

Route::get('/solicitudes', [SolicitudesController::class, 'index'])
    ->name('solicitud.index');

Route::get('/solicitud/show/{solicitud}', [SolicitudesController::class, 'show'])
    ->name('solicitud.show');
    
Route::get('/solicitud/solicitudByUser/{user_id}', [SolicitudesController::class, 'solicitudByUser'])
    ->name('solicitud.solicitudByUser');

Route::get('/solicitud/recientes', [SolicitudesController::class, 'recientes'])
    ->name('solicitud.recientes');


Route::post('/solicitud/store', [SolicitudesController::class, 'solicitudStore'])
    ->name('solicitud.store');

Route::put('/solicitud/update/status/{solicitud:id}', [SolicitudesController::class, 'solicitudUpdateStatus'])
    ->name('solicitud.status');


Route::delete('/solicitud/destroy/{solicitud}', [SolicitudesController::class, 'destroy'])
    ->name('solicitud.destroy');