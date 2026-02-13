<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TraineeFormController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Trainee\TraineeDashboardController;
use App\Http\Controllers\Trainee\MonthlyAttendanceController;
use App\Http\Controllers\Trainee\ProfileController;
use App\Http\Controllers\Supervisor\SupervisorDashboardController;
use App\Http\Controllers\Supervisor\SupervisorProfileController;
use App\Http\Controllers\HR\HRDashboardController;
use App\Http\Controllers\HR\TraineeMonthlyController;
use App\Http\Controllers\HR\SettingController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSvController;
use App\Http\Controllers\Admin\AdminTraineeController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () { 
    if (Auth::check()) {
        $role = Auth::user()->role;
        return match($role) {
            'admin'      => redirect()->route('admin.users.index'),
            'hr'         => redirect()->route('hr.dashboard'),
            'supervisor' => redirect()->route('supervisor.dashboard'),
            'trainee'    => redirect()->route('trainee.dashboard'),
            default      => redirect()->route('login'),
        };
    }
    return view('index'); 
})->name('home');

/**
 * FIX: Renamed this route to 'login.redirect'
 * It was previously named 'login', which conflicted with the actual login page.
 */
Route::match(['get', 'post'], '/redirect-to-index', function() {
    return redirect()->route('home');
})->name('login.redirect');

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
Route::middleware(['auth', 'role:admin', 'no.cache'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminUserController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');

    // Manage HR
    Route::get('/manage-hr', [AdminUserController::class, 'manageHr'])->name('managehr');
    Route::post('/hr/store', [AdminUserController::class, 'storeHr'])->name('hr.store');
    Route::put('/hr/update/{id}', [AdminUserController::class, 'updateHr'])->name('hr.update'); 
    Route::delete('/hr/{id}', [AdminUserController::class, 'destroyHr'])->name('hr.destroy');

    // Manage Supervisor
    Route::get('/manage-sv', [AdminSvController::class, 'manageSv'])->name('managesv');
    Route::post('/sv/store', [AdminSvController::class, 'storeSv'])->name('sv.store');
    Route::put('/sv/update/{id}', [AdminSvController::class, 'updateSv'])->name('sv.update');
    Route::delete('/sv/{id}', [AdminSvController::class, 'destroySv'])->name('sv.destroy');

    // Manage Trainee
    Route::get('/manage-trainee', [AdminTraineeController::class, 'index'])->name('managetrainee');
    Route::post('/trainee/store', [AdminTraineeController::class, 'store'])->name('trainee.store');
    Route::put('/trainee/update/{id}', [AdminTraineeController::class, 'update'])->name('trainee.update');
    Route::delete('/trainee/destroy/{id}', [AdminTraineeController::class, 'destroy'])->name('trainee.destroy');

    // Profile
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/emergency-exit', [AdminProfileController::class, 'emergencyExit'])->name('emergency.exit');
});

/*
|--------------------------------------------------------------------------
| HR Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:hr', 'no.cache'])->prefix('hr')->name('hr.')->group(function () {
    Route::get('/dashboard', [HRDashboardController::class, 'index'])->name('dashboard');
    Route::get('/applicants', [HRDashboardController::class, 'applicants'])->name('applicants');
    Route::get('/applicants/{id}', [HRDashboardController::class, 'show'])->name('applicants.show');
    
    // Approval/Rejection & Downloads
    Route::post('/applicants/approve/{id}', [HRDashboardController::class, 'approve'])->name('applicants.approve');
    Route::post('/applicants/reject/{id}', [HRDashboardController::class, 'reject'])->name('applicants.reject');
    Route::get('/applicants/download-form/{id}', [HRDashboardController::class, 'downloadApplicantForm'])->name('applicants.downloadForm');
    Route::get('/applicants/download-cv/{id}', [HRDashboardController::class, 'downloadCV'])->name('applicants.downloadCV');
    Route::get('/applicants/download-letter/{id}', [HRDashboardController::class, 'downloadLetter'])->name('applicants.downloadLetter');
    Route::delete('/applicants/{id}', [HRDashboardController::class, 'destroy'])->name('applicants.destroy');

    // Trainee Management
    Route::get('/trainees', [HRDashboardController::class, 'manageTrainees'])->name('trainees');
    Route::get('/trainees/inactive', [HRDashboardController::class, 'inactiveTrainees'])->name('trainees.inactive');
    Route::post('/trainees/store-account', [HRDashboardController::class, 'storeAccount'])->name('trainees.store_account');
    Route::post('/trainees/{id}/toggle-status', [HRDashboardController::class, 'toggleAccountStatus'])->name('trainees.toggle_status');
    Route::post('/trainees/{id}/archive', [HRDashboardController::class, 'archiveTrainee'])->name('trainees.archive');

    // STEP 2: Supervisor Assignment Logic
    Route::get('/assign-supervisor', [HRDashboardController::class, 'showAssignPage'])->name('attendance.assign');
    Route::post('/attendance/assign-supervisor/{id}', [HRDashboardController::class, 'assignSupervisor'])->name('attendance.assign_store');
    
    // Trainee Monthly Attendance Overview for HR
    Route::get('/submissions/trainee-monthly', [TraineeMonthlyController::class, 'index'])->name('submissions.traineeMonthly');
    Route::get('/submissions/trainee-monthly/export/{trainee}', [TraineeMonthlyController::class, 'exportPdf'])->name('submissions.traineeMonthly.export');
    Route::put('/submissions/trainee-monthly/set-global-rate', [TraineeMonthlyController::class, 'setGlobalRate'])->name('submissions.traineeMonthly.setGlobalRate');
    Route::put('/submissions/trainee-monthly/company-network-ips', [TraineeMonthlyController::class, 'setCompanyNetworkIps'])->name('submissions.traineeMonthly.setCompanyNetworkIps');

    // Settings: Allowance rate
    Route::get('/settings/allowance', [SettingController::class, 'editAllowance'])->name('settings.allowance.edit');
    Route::put('/settings/allowance', [SettingController::class, 'updateAllowance'])->name('settings.allowance.update');
});

/*
|--------------------------------------------------------------------------
| Trainee Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:trainee', 'no.cache'])->prefix('trainee')->name('trainee.')->group(function () {
    Route::get('/dashboard', [TraineeDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::put('/profile/personal-info', [ProfileController::class, 'updatePersonalInfo'])->name('profile.personalInfo');

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clockIn');

    // Monthly attendance summary + submit to HR (per trainee)
    Route::get('/monthly-attendance', [MonthlyAttendanceController::class, 'index'])->name('monthly.index');
    Route::post('/monthly-attendance', [MonthlyAttendanceController::class, 'store'])->name('monthly.store');
    Route::get('/monthly-attendance/export', [MonthlyAttendanceController::class, 'exportPdf'])->name('monthly.export');
});

/*
|--------------------------------------------------------------------------
| Supervisor Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:supervisor', 'no.cache'])->prefix('supervisor')->name('supervisor.')->group(function () {
    Route::get('/dashboard', [SupervisorDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/trainees', [SupervisorDashboardController::class, 'trainees'])->name('trainees');
    Route::get('/logbooks', [AttendanceController::class, 'supervisorIndex'])->name('logbooks');
    Route::get('/profile', [SupervisorProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [SupervisorProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [SupervisorProfileController::class, 'updatePassword'])->name('profile.password');
    Route::get('/tasks', [SupervisorDashboardController::class, 'tasks'])->name('tasks');

    // Existing attendance routes
    Route::get('/attendance-approvals', [AttendanceController::class, 'supervisorIndex'])->name('attendance.approvals');
    Route::get('/attendance/export-monthly/{trainee}', [AttendanceController::class, 'exportMonthlyPdf'])->name('attendance.exportMonthly');
    Route::post('/attendance/approve/{id}', [AttendanceController::class, 'approve'])->name('attendance.approve');
    Route::post('/attendance/reject/{id}', [AttendanceController::class, 'reject'])->name('attendance.reject');
});