<?php

use App\Http\Controllers\PostsController;
use App\Http\Controllers\FeedController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/post', [PostsController::class, 'index'])->name('post');
Route::post('/upload-curriculum', [PostsController::class, 'uploadCurriculum'])->name('curriculum.upload');
Route::get('/download-curriculum', [PostsController::class, 'downloadCurriculum'])->name('curriculum.download');

Route::get('/feeds', [FeedController::class, 'index'])->name('feeds.index');

Route::get('/download-curriculum/{id}', [PostsController::class, 'downloadUserCurriculum'])->name('curriculum.download.user');
