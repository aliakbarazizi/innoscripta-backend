<?php

use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::post('register', [\App\Http\Controllers\Auth\RegisterController::class, 'index'])
        ->name('register');

    Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])
        ->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [\App\Http\Controllers\Auth\LogoutController::class, 'index'])
        ->name('logout');

    Route::get('/me', [\App\Http\Controllers\UserController::class, 'me'])
        ->name('users.me');

    Route::get('articles/feed', [\App\Http\Controllers\ArticleController::class, 'feed'])
        ->name('articles.feed');

    Route::put('preferences', [\App\Http\Controllers\PreferenceController::class, 'update'])
        ->name('preferences.update');
});

Route::apiResource('categories', \App\Http\Controllers\CategoryController::class)
    ->only(['index', 'show']);

Route::apiResource('authors', \App\Http\Controllers\AuthorController::class)
    ->only(['index', 'show']);

Route::apiResource('sources', \App\Http\Controllers\SourceController::class)
    ->only(['index', 'show']);

Route::apiResource('articles', \App\Http\Controllers\ArticleController::class)
    ->only(['index', 'show']);
