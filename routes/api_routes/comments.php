<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

//Admin Usuarios
Route::get('/comments', [CommentController::class, 'index'])
    ->name('comments.index');

Route::get('/comments/show/{client}', [CommentController::class, 'commentShow'])
    ->name('comments.commentShow');

Route::get('/comments/show/ndoc/{n_doc}', [CommentController::class, 'showNdoc'])
    ->name('comments.showNdoc');


Route::put('/comments/update/{client}', [CommentController::class, 'commentUpdate'])
    ->name('comments.commentUpdate');

Route::delete('/comments/destroy/{client}', [CommentController::class, 'clientDestroy'])
    ->name('comments.destroy');

Route::get('/comments/recientes/', [CommentController::class, 'recientes'])
    ->name('comments.recientes');

    
    Route::get('/comments/commentBySolicitud/', [CommentController::class, 'commentBySolicitud'])
    ->name('comments.commentBySolicitud');
    
    Route::get('/comments/commentes-user/{user}', [CommentController::class, 'commentByUser'])
    ->name('comments.commentByUser');
    
    Route::get('/comments/contactos-cliente/{client}', [CommentController::class, 'commentByClient'])
    ->name('/comments.commentByClient');
    
Route::get('/comments/search/{request}', [CommentController::class, 'search'])
        ->name('comments.search');

        Route::post('/comments/commentStore/', [CommentController::class, 'commentStore'])
->name('comments.commentStore');

Route::delete('/comments/removeClientFromUser/{client}/{user}', [CommentController::class, 'removeClientFromUser'])
    ->name('comments.removeClientFromUser');

