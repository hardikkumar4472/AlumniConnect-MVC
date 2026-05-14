<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/', [AlumniController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AlumniController::class, 'dashboard'])->name('dashboard');
    Route::get('/directory', [AlumniController::class, 'directory'])->name('directory');
    Route::get('/network', [AlumniController::class, 'network'])->name('network');
    Route::get('/jobs', [AlumniController::class, 'jobs'])->name('jobs');
    Route::get('/events', [AlumniController::class, 'events'])->name('events');
    Route::get('/donations', [AlumniController::class, 'donations'])->name('donations');
    Route::post('/donations', [AlumniController::class, 'processDonation']);
    Route::get('/stories', [AlumniController::class, 'stories'])->name('stories');
    Route::get('/feedback', [AlumniController::class, 'feedback'])->name('feedback');
    Route::post('/feedback', [AlumniController::class, 'submitFeedback']);
    Route::get('/resources', [AlumniController::class, 'resources'])->name('resources');
    
    // Admin Routes
    Route::prefix('admin')->group(function () {
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
        Route::delete('/events/{id}', [AdminController::class, 'deleteEvent'])->name('admin.events.delete');
        
        // Story Management
        Route::get('/stories', [AdminController::class, 'stories'])->name('admin.stories');
        Route::post('/stories', [AdminController::class, 'storeStory'])->name('admin.stories.store');
        Route::delete('/stories/{id}', [AdminController::class, 'deleteStory'])->name('admin.stories.delete');

        // Feedback Management
        Route::get('/feedback', [AdminController::class, 'feedback'])->name('admin.feedback');
    });
});
