<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraineeFormController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Trainee\ProfileController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// ADDED middleware('multi.guest') HERE
Route::get('/', function () {
    return view('index');
})->name('home')->middleware('multi.guest');

// Internship Application Submission
Route::post('/apply', [TraineeFormController::class, 'store'])->name('trainee.store');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('multi.guest');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Dashboards (Multi-Auth)
|--------------------------------------------------------------------------
*/

// Trainee Routes
Route::middleware(['auth:trainee'])->prefix('trainee')->name('trainee.')->group(function () {
    Route::get('/dashboard', function () {
        return view('trainee.dashboard'); 
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});

// Supervisor Routes
Route::middleware(['auth:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('supervisor.dashboard'); 
    })->name('dashboard');
});

// HR Routes
Route::middleware(['auth:hr'])->prefix('hr')->name('hr.')->group(function () {
    Route::get('/dashboard', function () {
        return view('hr.dashboard'); 
    })->name('dashboard');
});