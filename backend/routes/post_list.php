<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostListController;


Route::name('post-list')
    ->prefix('post-list')
    ->group(function() {
        Route::get('/', [PostListController::class, 'index'])->name('index');
    });
