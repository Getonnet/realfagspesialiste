<?php

use App\Http\Controllers\DashboardController;
//use App\Http\Controllers\MainController;
use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Packages\PackagesController;
use App\Http\Controllers\Student\FrontStudentController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Subjects\SubjectsController;
use App\Http\Controllers\Teacher\FrontTeacherController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\User\RolesController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});*/
Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/', [FrontStudentController::class, 'index'])->name('student.package');

    Route::get('/dashboard', [FrontStudentController::class, 'dashboard'])->name('student.dashboard');

    Route::post('/order', [FrontStudentController::class, 'orders_save'])->name('package.orders');
    Route::get('/order', [FrontStudentController::class, 'orders'])->name('order.list');

    Route::get('/reports', [FrontStudentController::class, 'reports'])->name('my.reports');
    Route::get('/profile', [FrontStudentController::class, 'profile'])->name('my.profile');
    Route::put('/profile/{id}', [FrontStudentController::class, 'update_profile'])->name('update.myprofile');

    Route::get('/events', [FrontStudentController::class, 'events'])->name('student.events');
    Route::get('/events/overview/{id}', [FrontStudentController::class, 'overview'])->name('student.events-overview');//Overview light box
    Route::get('/events/all', [FrontStudentController::class, 'all_events'])->name('student.events-all');//Json for calender api
});


Route::prefix('teacher')->group(function () {
    Route::get('/register', [FrontTeacherController::class, 'register'])->name('teacher.register');

    Route::middleware(['auth', 'teacher'])->group(function () {
        Route::get('/', [FrontTeacherController::class, 'index'])->name('teacher.home');
        Route::get('/profile', [FrontTeacherController::class, 'profile'])->name('teacher.profile');
        Route::put('/profile/{id}', [FrontTeacherController::class, 'update_profile'])->name('update.teacher_profile');


        Route::put('/events/status/{id}', [FrontTeacherController::class, 'end_status'])->name('teacher.events-status-end');
        Route::get('/events/overview/{id}', [FrontTeacherController::class, 'overview'])->name('teacher.events-overview');//Overview light box
        Route::get('/events/status/{id}', [FrontTeacherController::class, 'running_status'])->name('teacher.events-status-running');
        Route::get('/events/all', [FrontTeacherController::class, 'all_events'])->name('teacher.events-all');//Json for calender api
        Route::delete('/events/{id}', [FrontTeacherController::class, 'del_event'])->name('teacher.events-del');
        Route::put('/events/{id}', [FrontTeacherController::class, 'event_edit'])->name('teacher.events-edit');
        Route::post('/events', [FrontTeacherController::class, 'event_save'])->name('teacher.events-save');
        Route::get('/events', [FrontTeacherController::class, 'events'])->name('teacher.events');

        Route::get('/pay', [FrontTeacherController::class, 'payments'])->name('teacher.pay');

        Route::get('/reports', [FrontTeacherController::class, 'reports'])->name('teacher.reports');
    });
});


Route::prefix('admin')->group(function () {
    Route::get('/register', [DashboardController::class, 'register'])->name('admin.register');

    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::put('/permissions/{id}', [RolesController::class, 'assign_role'])->name('permissions');
        Route::resource('/users/roles', RolesController::class);
        Route::resource('/users', UserController::class);

        Route::resource('/subjects', SubjectsController::class);
        Route::resource('/package', PackagesController::class);

        Route::resource('/student', StudentController::class);

        Route::delete('/teacher/payment/{id}', [TeacherController::class, 'del_payment'])->name('pay-del.teacher');
        Route::put('/teacher/payment/{teacher}', [TeacherController::class, 'payments'])->name('pay.teacher');
        Route::put('/teacher/payment-update/{id}', [TeacherController::class, 'pay_update'])->name('pay-update.teacher');
        Route::resource('/teacher', TeacherController::class);
        Route::resource('/orders', OrderController::class);
    });
});





/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');*/
