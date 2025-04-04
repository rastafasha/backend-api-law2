<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');

Route::get('/posts/recientes', [PostController::class, 'recientes'])
    ->name('post.recientes');

Route::get('/posts/destacados', [PostController::class, 'destacados'])
    ->name('post.destacados');

Route::post('/post/store', [PostController::class, 'postStore'])
    ->name('post.store');

Route::get('/post/show/{post}', [PostController::class, 'postShow'])
    ->name('post.postShow');

Route::get('/post/showcategory/{post}', [PostController::class, 'postShowWithCategory'])
    ->name('post.postShowWithCategory');

Route::get('/post/show/slug/{slug}', [PostController::class, 'postShowSlug'])
    ->name('post.postShowSlug');


Route::get('/post/category/{post}', [PostController::class, 'postByCategory'])
    ->name('post.postByCategory');

Route::put('/post/update/{post}', [PostController::class, 'postUpdate'])
    ->name('post.update');

Route::delete('/post/destroy/{post}', [PostController::class, 'destroy'])
    ->name('post.destroy');

Route::put('/post/update/status/{post:id}', [PostController::class, 'postUpdateStatus'])
    ->name('post.status');

Route::post('/post/upload', [PostController::class, 'upload'])
    ->name('post.upload');

Route::delete('/post/delete-foto/{id}', [PostController::class, 'deleteFotoPost'])
    ->name('post.deleteFotoPost');

Route::get('/post/search/', [PostController::class, 'search'])
    ->name('post.search');
