<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// Authentication Routes
Route::get('/auth', function () {
    return view('auth.auth');
})->name('auth');

// Chatbot Route
Route::get('/chat', function () {
    return view('chatbot');
})->name('chat');

// Profile Routes
Route::get('/profile', function () {
    return view('profile');
})->name('profile');