<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeartConnectionController;
use App\Http\Controllers\HeartSeparationController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Heart Connection routes
    Route::get('/heart-connections/create', [HeartConnectionController::class, 'create'])->name('heart-connections.create');
    Route::post('/heart-connections', [HeartConnectionController::class, 'store'])->name('heart-connections.store');
    Route::post('/heart-connections/{heartConnection}/accept', [HeartConnectionController::class, 'accept'])->name('heart-connections.accept');
    Route::post('/heart-connections/{heartConnection}/decline', [HeartConnectionController::class, 'decline'])->name('heart-connections.decline');
    
    // Heart Separation routes
    Route::get('/heart-separations/create', [HeartSeparationController::class, 'create'])->name('heart-separations.create');
    Route::post('/heart-separations', [HeartSeparationController::class, 'store'])->name('heart-separations.store');
    Route::post('/heart-separations/{heartSeparation}/approve', [HeartSeparationController::class, 'approve'])->name('heart-separations.approve');
    Route::post('/heart-separations/{heartSeparation}/decline', [HeartSeparationController::class, 'decline'])->name('heart-separations.decline');
    Route::delete('/heart-separations/{heartSeparation}/cancel', [HeartSeparationController::class, 'cancel'])->name('heart-separations.cancel');
});




