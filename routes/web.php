<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraineeFormController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Trainee\TraineeDashboardController;
use App\Http\Controllers\Trainee\ProfileController;
use App\Http\Controllers\Supervisor\SupervisorDashboardController;
use App\Http\Controllers\HR\HRDashboardController;
use App\Http\Controllers\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
// Using 'guest' middleware instead of 'multi.guest' to prevent login loops
Route::get('/', function () { 
    return view('index'); 
})->name('home');

Route::post('/apply', [TraineeFormController::class, 'store'])->name('trainee.store');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', function () { 
    return view('auth.login'); 
})->name('login')->middleware('guest');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ADMIN Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminUserController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users/store', [AdminUserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});

/*
|--------------------------------------------------------------------------
| HR Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:hr'])->prefix('hr')->name('hr.')->group(function () {
    Route::get('/dashboard', [HRDashboardController::class, 'index'])->name('dashboard');
    Route::get('/applicants', [HRDashboardController::class, 'applicants'])->name('applicants');
    Route::get('/applicants/{id}', [HRDashboardController::class, 'show'])->name('applicants.show');
    Route::get('/applicants/download-form/{id}', [HRDashboardController::class, 'downloadApplicantForm'])->name('applicants.downloadForm');
    Route::get('/applicants/download-cv/{id}', [HRDashboardController::class, 'downloadCV'])->name('applicants.downloadCV');
    Route::get('/applicants/download-letter/{id}', [HRDashboardController::class, 'downloadLetter'])->name('applicants.downloadLetter');
    
    Route::post('/applicants/approve/{id}', [HRDashboardController::class, 'approve'])->name('applicants.approve');
    Route::post('/applicants/reject/{id}', [HRDashboardController::class, 'reject'])->name('applicants.reject');
    Route::delete('/applicants/{id}', [HRDashboardController::class, 'destroy'])->name('applicants.destroy');

    Route::get('/trainees', [HRDashboardController::class, 'manageTrainees'])->name('trainees');
    Route::post('/trainees/store-account', [HRDashboardController::class, 'storeAccount'])->name('trainees.store_account');
});

/*
|--------------------------------------------------------------------------
| Trainee Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:trainee'])->prefix('trainee')->name('trainee.')->group(function () {
    Route::get('/dashboard', [TraineeDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});

/*
|--------------------------------------------------------------------------
| Supervisor Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:supervisor'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('/dashboard', [SupervisorDashboardController::class, 'index'])->name('dashboard');
});