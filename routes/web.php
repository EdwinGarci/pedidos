<?php

// use App\Http\Controllers\DashboardController;

use App\Http\Controllers\Supplier\SupplierController;
use App\Http\Controllers\Attendance\AttendanceController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Auth\SigInController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Schedule\ScheduleController;
use App\Http\Controllers\Setting\UserController;
use App\Http\Controllers\Upload\UploadController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/', [\App\Http\Controllers\Auth\SigInController::class, 'index'])->name('login');
    Route::post('/', [\App\Http\Controllers\Auth\SigInController::class, 'signIn']);
});

Route::post('/logout', [\App\Http\Controllers\Auth\SigInController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\v1\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [ReportController::class, 'index']);
    Route::get('/reports/reportPdf', [ReportController::class, 'generatePdf']);
    Route::get('/upload', [UploadController::class, 'index']);
    Route::get('/supplier', [SupplierController::class, 'index']);
    Route::get('/schedule', [ScheduleController::class, 'index']);
    Route::get('/attendance', [AttendanceController::class, 'index']);
    Route::get('/teacher', [TeacherController::class, 'index']);
    Route::get('/usuario', [UserController::class, 'user']);
    Route::get('/rol', [UserController::class, 'rol']);
});
