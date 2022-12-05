<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;


Route::name('posts.')
    ->prefix('posts')
    ->group(function() {
        Route::get('/', [PostController::class, 'index'])
            ->name('index');
        Route::get('/{post}', [PostController::class, 'show'])
            ->name('show')
            ->whereNumber('id');
    });
