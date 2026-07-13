<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\NHISController;
use App\Http\Controllers\Admin\InsuranceClaimController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Redirect root to dashboard or login
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
})->name('home');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Patient Management
    Route::resource('patients', PatientController::class);

    // Appointments
    Route::resource('appointments', AppointmentController::class);
    Route::patch('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // NHIS Management
    Route::resource('nhis', NHISController::class);
    Route::patch('nhis/{membership}/renew', [NHISController::class, 'renew'])->name('nhis.renew');

    // Insurance Claims
    Route::resource('claims', InsuranceClaimController::class);
    Route::patch('claims/{claim}/submit', [InsuranceClaimController::class, 'submit'])->name('claims.submit');
    Route::patch('claims/{claim}/approve', [InsuranceClaimController::class, 'approve'])->name('claims.approve');
    Route::patch('claims/{claim}/reject', [InsuranceClaimController::class, 'reject'])->name('claims.reject');

    // Settings
    Route::get('/settings/profile', function () {
        return view('settings.profile');
    })->name('settings.profile');

    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password.update');
});
