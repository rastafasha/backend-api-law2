<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;


Route::get('/profiles', [ProfileController::class, 'index'])
    ->name('profile.index');

Route::post('/profile/store', [ProfileController::class, 'profileStore'])
    ->name('profile.store');

Route::get('/profile/show/{profile}', [ProfileController::class, 'profileShow'])
    ->name('profile.show');

Route::get('/profile/showbyUser/{user}', [ProfileController::class, 'profilebyUser'])
    ->name('profile.profilebyUser');

Route::get('/profile/showbyClient/{client}', [ProfileController::class, 'profilebyClient'])
    ->name('profile.profilebyClient');

Route::get('/profile/profilebyUserFiltered/', [ProfileController::class, 'profileFiltered'])
    ->name('profile.profileFiltered');
// Route::get('/profile/profileFiltered/{pais?}/{speciality_id?}/{rating?}', [ProfileController::class, 'profileFiltered'])
//     ->name('profile.profileFiltered');

Route::get('/profile/recientes', [ProfileController::class, 'recientes'])
    ->name('profile.recientes');

Route::get('/profile/destacados', [ProfileController::class, 'destacados'])
    ->name('profile.destacados');

Route::post('/profile/update/{profile}', [ProfileController::class, 'profileUpdate'])
    ->name('profile.update');

Route::delete('/profile/destroy/{profile}', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');


Route::put('/profile/update/status/{profile:id}', [ProfileController::class, 'updateStatus'])
    ->name('profile.updateStatus');


