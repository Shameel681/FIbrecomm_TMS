<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TraineeFormController;

Route::get('/', function () {
    return view('index');
});

Route::post('/apply', [TraineeFormController::class, 'store'])->name('trainee.store');


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Process Login (Placeholder for now)
Route::post('/login', function () {
    return "Login logic is working! Redirecting...";
});