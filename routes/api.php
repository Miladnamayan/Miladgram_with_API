<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('miladgram')->group(function(){

    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum')->name('logout');

    Route::prefix('admin')->name('admin.')->controller(UserController::class)->middleware('auth:sanctum','admin')->group(function(){
        Route::get('/', 'list')->name('list');
        Route::delete('/{user}', 'delete')->name('delete');
        Route::post('/{user}', 'accept')->name('accept');
    });

    Route::prefix('posts')->name('posts.')->middleware('auth:sanctum')->group(function(){
    // Route::prefix('posts')->name('posts.')->group(function(){
        //is it true?!  posts/Author/...
        Route::prefix('Author')->name('Author.')->controller(AuthorController::class)->middleware('Author')->group(function(){
        // Route::prefix('Author')->name('Author.')->controller(AuthorController::class)->group(function(){
            Route::post('/', 'create')->name('create');
            Route::put('/{post}', 'update')->name('update');
            Route::delete('/{post}', 'delete')->name('delete');
            Route::post('/{post}', 'permission')->name('permission');

        });
        Route::prefix('Public')->name('Public.')->controller(PostController::class)->group(function(){
            Route::get('/', 'list')->name('list');
            Route::get('/{post}', 'show')->name('show');
            Route::post('/{post}/comments', 'Comment')->name('comment');
            Route::post('/{post}/likes', 'like')->name('like');
        });
    });

});





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


