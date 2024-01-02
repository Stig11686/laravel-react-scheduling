<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\CohortController;
use App\Http\Controllers\Api\V1\EmployerController;
use App\Http\Controllers\Api\V1\CohortSessionController;
use App\Http\Controllers\Api\V1\SessionController;
use App\Http\Controllers\Api\V1\ScheduleController;
use App\Http\Controllers\Api\V1\TrainerController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ZoomRoomController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\AttendanceController;
use App\Http\Resources\UserResource;

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



Route::post('/login', [AuthController::class, 'login'])->name('login');





Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        $user = Auth::user();
        $user->load('roles', 'permissions'); // Eager load roles and permissions

        return response()->json(['data' => new UserResource( $user )]);
    });

    Route::post('/logout', [AuthController::class, 'logout']);


    Route::middleware(['can:view_admin_area'])->group(function(){
        Route::resource('/courses', CourseController::class);
        Route::resource('/cohorts', CohortController::class);
        Route::resource('/sessions', SessionController::class);
        Route::resource('/employers', EmployerController::class);
        Route::resource('/tasks', TaskController::class);
        Route::resource('/trainers', TrainerController::class);
        Route::resource('/zoom_rooms', ZoomRoomController::class);
        Route::resource('/cohort_session', CohortSessionController::class);
        Route::resource('/users', UserController::class);
        Route::get('/sessionsAll', [SessionController::class, 'allSessions']);
        Route::get('/trainersAll', [TrainerController::class, 'allTrainers']);
        Route::get('/cohortsAll', [CohortController::class, 'allCohorts']);
        Route::get('/coursesAll', [CourseController::class, 'allCourses']);
        Route::get('/cohorts/{cohort}/attendance', [AttendanceController::class, 'getCohortAttendance']);
    });

    Route::resource('/schedule', ScheduleController::class);


});



