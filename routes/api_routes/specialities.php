<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpecialityController;

Route::get('/specialities', [SpecialityController::class, 'index'])
    ->name('speciality.index');
Route::get('/specialities/filtradoMayorCero', [SpecialityController::class, 'filtradoMayorCero'])
    ->name('speciality.filtradoMayorCero');

Route::get('/speciality/show/{speciality}', [SpecialityController::class, 'show'])
    ->name('speciality.show');
    
Route::get('/speciality/showWithUsers/{speciality}', [SpecialityController::class, 'showWithUsers'])
    ->name('speciality.showWithUsers');
    

Route::get('/speciality/recientes', [SpecialityController::class, 'recientes'])
    ->name('speciality.recientes');

Route::get('/speciality/destacados', [SpecialityController::class, 'destacados'])
    ->name('speciality.destacados');

Route::get('/speciality/specialityFiltered/{pais?}/{speciality_id?}/{rating?}', [SpecialityController::class, 'specialityFiltered'])
    ->name('speciality.specialityFiltered');

Route::post('/speciality/store', [SpecialityController::class, 'specialityStore'])
    ->name('speciality.store');

Route::put('/speciality/update/{speciality}', [SpecialityController::class, 'specialityUpdate'])
    ->name('speciality.update');

Route::put('/speciality/update/status/{speciality:id}', [SpecialityController::class, 'specialityUpdateStatus'])
    ->name('speciality.status');

Route::get('/speciality/search/', [SpecialityController::class, 'search'])
    ->name('speciality.search');

Route::delete('/speciality/destroy/{speciality}', [SpecialityController::class, 'destroy'])
    ->name('speciality.destroy');