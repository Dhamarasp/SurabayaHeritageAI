<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Guest routes
Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, 'index'])->name('auth');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Authenticated routes
Route::middleware('auth')->group(function(){
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/preferences', [ProfileController::class, 'updatePreferences'])->name('profile.preferences');
    Route::post('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.delete');
    
    // Admin routes
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function(){
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');

        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::put('/user/{id}/password', [UserController::class, 'updatePassword'])->name('user.update.password');
        Route::delete('/user/{id}', [UserController::class, 'delete'])->name('user.delete');
    });
});
