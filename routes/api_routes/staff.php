<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Staff\StaffsController;


Route::get('staffs', [StaffsController::class, 'index'])->name('staffs.index');
Route::get('staffs/config', [StaffsController::class, 'config'])->name('staffs.config');
Route::post('staffs/store', [StaffsController::class, 'store'])->name('staffs.store');
Route::get('staffs/show/{id}', [StaffsController::class, 'show'])->name('staffs.show');
Route::post('staffs/update/{role}', [StaffsController::class, 'update'])->name('staffs.update');
Route::delete('staffs/destroy/{id}', [StaffsController::class, 'destroy'])->name('staffs.destroy');

