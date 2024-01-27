<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::prefix('miladgram')->group(function(){

    Route::post('/Register', [RegisterController::class, 'Register'])->name('Register');
    Route::post('/Login', [LoginController::class, 'Login'])->name('Login');
    Route::post('/Logout', [LogoutController::class, 'Logout'])->middleware('auth:sanctum')->name('Logout');

    Route::prefix('Users')->name('Users.')->controller(UserController::class)->middleware('auth:sanctum','admin')->group(function(){
        Route::get('/', 'List')->name('List');
        Route::delete('/{user}', 'Delete')->name('Delete');
        Route::post('/{user}', 'Accept')->name('Accept');
    });

    Route::prefix('posts')->name('posts.')->middleware('auth:sanctum')->group(function(){
        //is it true?!  posts/Author/...
        Route::prefix('Author')->name('Author.')->controller(AuthorController::class)->middleware('Author')->group(function(){
            Route::post('/', 'Create')->name('Create');
            Route::put('/{post}', 'Update')->name('Update');
            Route::delete('/{post}', 'Delete')->name('Delete');
            Route::post('/{post}', 'Permission')->name('Permission');

        });
        Route::prefix('Public')->name('Public.')->controller(PostController::class)->group(function(){
            Route::get('/', 'list')->name('list');
            Route::get('/{post}', 'Show')->name('Show');
            Route::post('/{post}/comments', 'Comment')->name('Comment');
            Route::post('/{post}/likes', 'Like')->name('Like');
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


