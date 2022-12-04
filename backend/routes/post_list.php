<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostListController;


Route::name('post-lists')
    ->prefix('post-lists')
    ->group(function() {
        Route::get('/', [PostListController::class, 'index'])->name('index');
    });
