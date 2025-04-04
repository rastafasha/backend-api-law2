<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\PatientController;

Route::get('patients', [PatientController::class, 'index'])->name('index');
Route::post('patients/store', [PatientController::class, 'store'])->name('store');
Route::get('patients/show/{id}', [PatientController::class, 'show'])->name('show');
Route::get('patients/show_patdoc/{n_doc}', [PatientController::class, 'showPatientIdentifier'])->name('showPatientIdentifier');
Route::post('patients/update/{patient}', [PatientController::class, 'update'])->name('update');
Route::delete('patients/destroy/{id}', [PatientController::class, 'destroy'])->name('destroy');

Route::get('patients/profile/{id}', [PatientController::class, 'profile'])->name('profile');
