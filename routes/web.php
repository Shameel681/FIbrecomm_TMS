<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraineeFormController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Trainee\TraineeDashboardController;
use App\Http\Controllers\Trainee\ProfileController;
use App\Http\Controllers\Supervisor\SupervisorDashboardController;
use App\Http\Controllers\HR\HRDashboardController;

// Public Routes
Route::get('/', function () { return view('index'); })->name('home')->middleware('multi.guest');
Route::post('/apply', [TraineeFormController::class, 'store'])->name('trainee.store');

// Auth Routes
Route::get('/login', function () { return view('auth.login'); })->name('login')->middleware('multi.guest');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// HR Protected Routes
Route::middleware(['auth:hr'])->prefix('hr')->name('hr.')->group(function () {
    Route::get('/dashboard', [HRDashboardController::class, 'index'])->name('dashboard');
    Route::get('/applicants', [HRDashboardController::class, 'applicants'])->name('applicants');
    Route::get('/applicants/{id}', [HRDashboardController::class, 'show'])->name('applicants.show');
    Route::get('/applicants/download-form/{id}', [HRDashboardController::class, 'downloadApplicantForm'])->name('applicants.downloadForm');
    Route::get('/applicants/download-cv/{id}', [HRDashboardController::class, 'downloadCV'])->name('applicants.downloadCV');
    Route::get('/applicants/download-letter/{id}', [HRDashboardController::class, 'downloadLetter'])->name('applicants.downloadLetter');
    Route::delete('/applicants/{id}', [HRDashboardController::class, 'destroy'])->name('applicants.destroy');
    Route::get('/trainees', [HRDashboardController::class, 'manageTrainees'])->name('trainees');
});

// Trainee Protected Routes
Route::middleware(['auth:trainee'])->prefix('trainee')->name('trainee.')->group(function () {
    Route::get('/dashboard', [TraineeDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});

// Supervisor Protected Routes
Route::middleware(['auth:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('/dashboard', [SupervisorDashboardController::class, 'index'])->name('dashboard');
});