<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraineeFormController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Trainee\TraineeDashboardController;
use App\Http\Controllers\Trainee\ProfileController;
use App\Http\Controllers\Supervisor\SupervisorDashboardController;
use App\Http\Controllers\HR\HRDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSvController;

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
    // Command Center
    Route::get('/dashboard', [AdminUserController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');

    // Manage HR Routes (Stay with AdminUserController)
    Route::get('/manage-hr', [AdminUserController::class, 'manageHr'])->name('managehr');
    Route::post('/hr/store', [AdminUserController::class, 'storeHr'])->name('hr.store');
    Route::put('/hr/update/{id}', [AdminUserController::class, 'updateHr'])->name('hr.update'); 
    Route::delete('/hr/{id}', [AdminUserController::class, 'destroyHr'])->name('hr.destroy');

    // Manage Supervisor Routes (MOVED TO AdminSvController)
    Route::get('/manage-sv', [AdminSvController::class, 'manageSv'])->name('managesv');
    Route::post('/sv/store', [AdminSvController::class, 'storeSv'])->name('sv.store');
    Route::put('/sv/update/{id}', [AdminSvController::class, 'updateSv'])->name('sv.update'); // Added this
    Route::delete('/sv/{id}', [AdminSvController::class, 'destroySv'])->name('sv.destroy');

    // Manage Trainee Routes
    Route::get('/manage-trainee', [AdminUserController::class, 'manageTrainee'])->name('managetrainee');
    Route::post('/trainee/store', [AdminUserController::class, 'storeTrainee'])->name('trainee.store');
    Route::delete('/trainee/{id}', [AdminUserController::class, 'destroyTrainee'])->name('trainee.destroy');
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