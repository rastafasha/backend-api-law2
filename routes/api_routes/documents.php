<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Document\DocumentController;

// Route::apiResource('documents', DocumentController::class);


Route::get('/documents', [DocumentController::class, 'index'])
    ->name('documents.index');

Route::get('/documents/showByUserFiltered', [DocumentController::class, 'showDocumentFiltered'])
        ->name('documents.showDocumentFiltered');
        
Route::get('/documents/show/{document}', [DocumentController::class, 'show'])
    ->name('documents.show');

Route::get('/documents/showbyuser/{user}', [DocumentController::class, 'showByUser'])
    ->name('documents.showByUser');

Route::get('/documents/showbyclient/{client}', [DocumentController::class, 'showByClient'])
    ->name('documents.showByClient');
    

Route::post('/documents/showByCategory/', [DocumentController::class, 'showByCategory'])
    ->name('documents.showByCategory');

Route::get('/documents/showByClientCategory/{client}/{category_name}', [DocumentController::class, 'showByClientCategory'])
    ->name('documents.showByClientCategory');

Route::get('/documents/recientes', [DocumentController::class, 'recientes'])
    ->name('documents.recientes');

Route::get('/documents/destacados', [DocumentController::class, 'destacados'])
    ->name('documents.destacados');

Route::post('/documents/store', [DocumentController::class, 'store'])
    ->name('documents.store');

Route::put('/documents/update/{document}', [DocumentController::class, 'documentUpdate'])
    ->name('documents.update');

Route::put('/documents/update/status/{document:id}', [DocumentController::class, 'documentUpdateStatus'])
    ->name('documents.status');

Route::get('/documents/search/', [DocumentController::class, 'search'])
    ->name('documents.search');

Route::delete('/documents/destroy/{document}', [DocumentController::class, 'destroy'])
    ->name('documents.destroy');

Route::post('/documents/share/', [DocumentController::class, 'shareToClient'])
    ->name('documents.share');

    

Route::post('/documents/sharegroup/{document}/{client}/{namecategory}', [DocumentController::class, 'shareGroupClientByNameCategory'])
    ->name('documents.shareGroupClientByNameCategory');

