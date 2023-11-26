<?php

use App\Http\Controllers\Area\AreaController;
use App\Http\Controllers\Attendance\AttendanceController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Schedule\ScheduleController;
use App\Http\Controllers\Setting\UserController;
use App\Http\Controllers\Upload\UploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('guest')->group( function() {

    // RUTAS DE REPORTES
    Route::get('/report', [ReportController::class, 'index']);
    Route::post('/report-generate', [ReportController::class, 'generatePdf']);

    // RUTAS DE SUBIDAS
    Route::get('/upload', [UploadController::class, 'index']);
    Route::post('/upload-excel', [UploadController::class, 'uploadExcel']);
    Route::post('/save-attendances', [UploadController::class, 'saveAttendancesOfExcel']);

    // RUTAS DE AREA
    Route::post('/data-area', [AreaController::class, 'dataArea']);
    Route::post('/create-area', [AreaController::class, 'createArea']);
    Route::post('/save-area', [AreaController::class, 'saveArea']);
    Route::post('/edit-area/{id}', [AreaController::class, 'editArea']);
    Route::patch('/update-area/{id}', [AreaController::class, 'updateArea']);
    Route::delete('/delete-area/{id}', [AreaController::class, 'deleteArea']);

    // RUTAS DE CRONOGRAMA(SCHEDULE)
    Route::post('/data-schedule', [ScheduleController::class, 'dataSchedule']);
    Route::post('/create-schedule', [ScheduleController::class, 'createSchedule']);
    Route::post('/save-schedule', [ScheduleController::class, 'saveSchedule']);
    Route::post('/edit-schedule/{id}', [ScheduleController::class, 'editSchedule']);
    Route::patch('/update-schedule/{id}', [ScheduleController::class, 'updateSchedule']);
    Route::delete('/delete-schedule/{id}', [ScheduleController::class, 'deleteSchedule']);

    // RUTAS DE ASISTENCIA(ATTENDANCE)
    Route::post('/data-attendance', [AttendanceController::class, 'dataAttendance']);
    Route::post('/create-attendance', [AttendanceController::class, 'createAttendance']);
    Route::post('/save-attendance', [AttendanceController::class, 'saveAttendance']);
    Route::post('/edit-attendance/{id}', [AttendanceController::class, 'editAttendance']);
    Route::patch('/update-attendance/{id}', [AttendanceController::class, 'updateAttendance']);
    Route::delete('/delete-attendance/{id}', [AttendanceController::class, 'deleteAttendance']);

    // RUTAS DE MAESTROS
    Route::post('/data-teacher', [TeacherController::class, 'dataTeacher']);
    Route::post('/create-teacher', [TeacherController::class, 'createTeacher']);
    Route::post('/save-teacher', [TeacherController::class, 'saveTeacher']);
    Route::post('/edit-teacher/{id}', [TeacherController::class, 'editTeacher']);
    Route::patch('/update-teacher/{id}', [TeacherController::class, 'updateTeacher']);
    Route::delete('/delete-teacher/{id}', [TeacherController::class, 'deleteTeacher']);

    Route::post('/get-rols', [UserController::class, 'get_rols_api']);
    Route::post('/get-users', [UserController::class,'get_users_api']);

    Route::post('/component-user-table', [UserController::class, 'user_table']);
});
