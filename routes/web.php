<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\JobController;

Route::get('/', [AlumniController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AlumniController::class, 'dashboard'])->name('dashboard');
    Route::get('/directory', [AlumniController::class, 'directory'])->name('directory');
    Route::get('/profile/{id}', [AlumniController::class, 'profile'])->name('profile');
    Route::get('/network', [AlumniController::class, 'network'])->name('network');
    
    // Connection Routes
    Route::post('/connect/{id}', [ConnectionController::class, 'sendRequest'])->name('connect.request');
    Route::post('/connect/{id}/accept', [ConnectionController::class, 'acceptRequest'])->name('connect.accept');
    Route::post('/connect/{id}/reject', [ConnectionController::class, 'rejectRequest'])->name('connect.reject');

    // Chat Routes
    Route::get('/network/chat/{id}', [\App\Http\Controllers\ChatController::class, 'chat'])->name('chat');
    Route::get('/network/chat/{id}/messages', [\App\Http\Controllers\ChatController::class, 'fetchMessages']);
    Route::post('/network/chat/{id}/send', [\App\Http\Controllers\ChatController::class, 'sendMessage']);

    Route::get('/jobs', [AlumniController::class, 'jobs'])->name('jobs');
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
    Route::post('/jobs/{id}/apply', [JobController::class, 'apply'])->name('jobs.apply');
    Route::get('/jobs/{id}/applications', [JobController::class, 'viewApplications'])->name('jobs.applications');
    Route::get('/applications/{id}/resume', [JobController::class, 'downloadResume'])->name('jobs.resume');
    Route::get('/events', [AlumniController::class, 'events'])->name('events');
    Route::get('/donations', [AlumniController::class, 'donations'])->name('donations');
    Route::post('/donations', [AlumniController::class, 'processDonation']);
    Route::get('/stories', [AlumniController::class, 'stories'])->name('stories');
    Route::get('/feedback', [AlumniController::class, 'feedback'])->name('feedback');
    Route::post('/feedback', [AlumniController::class, 'submitFeedback']);
    Route::get('/resources', [AlumniController::class, 'resources'])->name('resources');
    
    // Admin Routes
    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        
        // User Management
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::post('/users/{id}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.role');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        
        // Job Management
        Route::get('/jobs', [AdminController::class, 'jobs'])->name('admin.jobs');
        Route::post('/jobs', [AdminController::class, 'storeJob'])->name('admin.jobs.store');
        Route::delete('/jobs/{id}', [AdminController::class, 'deleteJob'])->name('admin.jobs.delete');
        
        // Event Management
        Route::get('/events', [AdminController::class, 'events'])->name('admin.events');
        Route::post('/events', [AdminController::class, 'storeEvent'])->name('admin.events.store');
        Route::put('/events/{id}', [AdminController::class, 'updateEvent'])->name('admin.events.update');
        Route::delete('/events/{id}', [AdminController::class, 'deleteEvent'])->name('admin.events.delete');
        
        // Story Management
        Route::get('/stories', [AdminController::class, 'stories'])->name('admin.stories');
        Route::post('/stories', [AdminController::class, 'storeStory'])->name('admin.stories.store');
        Route::put('/stories/{id}', [AdminController::class, 'updateStory'])->name('admin.stories.update');
        Route::delete('/stories/{id}', [AdminController::class, 'deleteStory'])->name('admin.stories.delete');

        // Resource Management
        Route::get('/resources', [AdminController::class, 'resources'])->name('admin.resources');
        Route::post('/resources', [AdminController::class, 'storeResource'])->name('admin.resources.store');
        Route::put('/resources/{id}', [AdminController::class, 'updateResource'])->name('admin.resources.update');
        Route::delete('/resources/{id}', [AdminController::class, 'deleteResource'])->name('admin.resources.delete');

        // Feedback Management
        Route::get('/news', [AdminController::class, 'news'])->name('admin.news');
        Route::post('/news', [AdminController::class, 'storeNews'])->name('admin.news.store');
        Route::put('/news/{id}', [AdminController::class, 'updateNews'])->name('admin.news.update');
        Route::delete('/news/{id}', [AdminController::class, 'deleteNews'])->name('admin.news.delete');
        
        Route::get('/feedback', [AdminController::class, 'feedback'])->name('admin.feedback');
    });
});
