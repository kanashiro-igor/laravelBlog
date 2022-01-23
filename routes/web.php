<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');

Route::get('posts/{post:slug}', [PostController::class, 'show']);


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'create']);
    Route::post('register', [RegisterController::class, 'store']);
    Route::get('login', [SessionsController::class, 'create']);
    Route::post('login', [SessionsController::class, 'store']);
});
    
// Route::get('register', [RegisterController::class, 'create'])->middleware('guest');

// Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::middleware('auth')->group(function() {
    Route::post('logout', [SessionsController::class, 'destroy']);
    Route::post('posts/{post:slug}/comments', [PostCommentsController::class, 'store']);
});
