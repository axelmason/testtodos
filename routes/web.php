<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::controller(AuthController::class)->name('auth.')->group(function() {
    Route::middleware('guest')->group(function() {
        Route::get('/register', 'registerPage')->name('registerPage');
        Route::post('/register', 'register')->name('register');

        Route::get('/login', 'loginPage')->name('loginPage');
        Route::post('/login', 'login')->name('login');
    });

    Route::middleware('auth')->group(function() {
        Route::get('/logout', 'logout')->name('logout');
    });
});

Route::middleware('auth')->group(function() {
    Route::name('todo.')->prefix('/todo')->controller(TodoController::class)->group(function() {
        Route::get('/create', 'createPage')->name('createPage');
        Route::post('/create', 'create')->name('create');

        Route::get('/search', 'search')->name('search');

        Route::get('/{todo_id}', 'show')->name('show');


        Route::post('/{todo_id}/image/upload', 'uploadImage');
        Route::get('/{todo_id}/image/delete', 'deleteImage')->name('deleteImage');

        Route::post('/status-toggler', 'statusToggler');

        Route::post('/{todo_id}/tags/attach', 'attachTags')->name('attachTags');
        Route::post('/{todo_id}/tags/detach', 'detachTags')->name('detachTags');

        Route::post('/{todo_id}/giveAccess', 'giveAccess')->name('giveAccess');
        Route::get('/{todo_id}/removeAccess/{member_id}', 'removeAccess')->name('removeAccess');
    });

    Route::name('tag.')->prefix('/tag')->controller(TagController::class)->group(function() {
        Route::post('/create', 'create');
        Route::post('/delete', 'delete');
    });
});
