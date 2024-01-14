<?php

use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\Login\LoginController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::controller(LoginController::class)->group(function () {
    Route::post('/login', 'login_user')->name('login_user');
    Route::get('/logout', 'logout_user')->middleware('auth:sanctum')->name('logout_user');
});

Route::middleware('auth:sanctum')->group(function () {
    // post APi
    Route::get('/index', [PostController::class, 'index'])->name('post.index');
    Route::post('/post', [PostController::class, 'store'])->name('post.store');
    Route::post('/post{id}/update', [PostController::class, 'update'])->name('post.update');
    Route::get('/post/{id}/delete', [PostController::class, 'destroy'])->name('post.update');

    Route::post('/comments', [CommentController::class, 'store'])->name('comment.store');

});
