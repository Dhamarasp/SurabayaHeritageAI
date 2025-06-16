<?php

use App\Http\Controllers\Admin\ConversationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KeywordController;
use App\Http\Controllers\Admin\KnowledgeEntryController;
use App\Http\Controllers\Admin\PopularTopicController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Chat routes - protected by auth middleware
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/process', [ChatController::class, 'processMessage'])->name('chat.process');
    Route::get('/chat/history', [ChatController::class, 'getHistory'])->name('chat.history');
    Route::get('/chat/messages/{conversationId}', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/new', [ChatController::class, 'newConversation'])->name('chat.new');
});

// Admin routes - protected by auth and admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', UserController::class);
    
    // Knowledge Base Management
    Route::resource('knowledge', KnowledgeEntryController::class);
    
    // Keyword Management
    Route::resource('keywords', KeywordController::class);
    Route::patch('keywords/{keyword}/toggle-status', [KeywordController::class, 'toggleStatus'])->name('keywords.toggle-status');
    
    // Popular Topics Management
    Route::resource('popular-topics', PopularTopicController::class);
    Route::patch('popular-topics/{popularTopic}/toggle-status', [PopularTopicController::class, 'toggleStatus'])->name('popular-topics.toggle-status');
    Route::post('popular-topics/reorder', [PopularTopicController::class, 'reorder'])->name('popular-topics.reorder');
    
    // Conversation Management
    Route::get('conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::delete('conversations/{conversation}', [ConversationController::class, 'destroy'])->name('conversations.destroy');
    Route::get('conversations-statistics', [ConversationController::class, 'statistics'])->name('conversations.statistics');
});
