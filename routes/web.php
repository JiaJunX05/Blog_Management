<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Auth\AuthController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\GuestController;
use App\Http\Middleware\UserAuth;

// Guest routes
Route::get('/', [GuestController::class, 'dashboard'])->name('guest.dashboard');
Route::get('/view/{id}', [GuestController::class, 'viewPost'])->name('gurst.view');

// User routes
Route::prefix('user')->group(function() {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('user.login');
    Route::post('/login', [AuthController::class, 'login'])->name('user.login.submit');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('user.register');
    Route::post('/register', [AuthController::class, 'register'])->name('user.register.submit');

    Route::middleware([UserAuth::class])->group(function() {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('user.dashboard');

        Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');

        Route::get('/dashboard', [PostController::class, 'dashboard'])->name('user.dashboard');
        Route::get('/view/{id}', [PostController::class, 'viewPost'])->name('user.view');

        Route::get('/create', [PostController::class, 'showCreateForm'])->name('user.create');
        Route::post('/create', [PostController::class, 'create'])->name('user.create.submit');

        Route::get('/edit/{id}', [PostController::class, 'showEditForm'])->name('user.edit');
        Route::put('/edit/{id}', [PostController::class, 'update'])->name('user.edit.submit');

        Route::delete('/delete/{id}', [PostController::class, 'destroy'])->name('deletePost');
    });
});