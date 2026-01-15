<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\ProfileController;

// Route Login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login')
    ->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Routes untuk semua user yang sudah login
Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return app(DashboardController::class)->index();
        }
        return app(DashboardController::class)->user();
    })->name('dashboard');

    // Routes untuk User Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // Routes khusus ADMIN saja
    Route::middleware('admin')->group(function () {
        Route::resource('employees', EmployeeController::class);
        Route::get('employees/export/excel', [EmployeeController::class, 'export'])->name('employees.export');
        Route::resource('departments', DepartmentController::class);
        Route::resource('positions', PositionController::class);
        Route::resource('salaries', SalaryController::class);
    });

    // Routes untuk ADMIN dan USER
    Route::resource('attendances', AttendanceController::class)->only(['index', 'show', 'create', 'store', 'destroy']);
});