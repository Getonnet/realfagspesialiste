<?php

use App\Http\Controllers\DashboardController;
//use App\Http\Controllers\MainController;
use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Packages\PackagesController;
use App\Http\Controllers\Reports\ReportController;
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
});
*/

Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/', [FrontStudentController::class, 'index'])->name('student.package');

    Route::get('/dashboard', [FrontStudentController::class, 'dashboard'])->name('student.dashboard');

    Route::post('/order', [FrontStudentController::class, 'orders_save'])->name('package.orders');
    Route::get('/order', [FrontStudentController::class, 'orders'])->name('order.list');

    Route::post('/reports', [FrontStudentController::class, 'show_reports'])->name('student.reports');
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
        Route::get('/events/overview-mini/{id}', [FrontTeacherController::class, 'overview_mini'])->name('teacher.events-overview-mini');//Overview Mini light box
        Route::get('/events/status/{id}', [FrontTeacherController::class, 'running_status'])->name('teacher.events-status-running');
        Route::get('/events/all', [FrontTeacherController::class, 'all_events'])->name('teacher.events-all');//Json for calender api
        Route::delete('/events/{id}', [FrontTeacherController::class, 'del_event'])->name('teacher.events-del');
        Route::delete('/events/file-delete/{id}', [FrontTeacherController::class, 'delete_up_file'])->name('teacher.events-file-del');
        Route::put('/events/updates/{id}', [FrontTeacherController::class, 'edit_events'])->name('teacher.events-update');
        Route::post('/events/add', [FrontTeacherController::class, 'add_new_event'])->name('teacher.events-add');
        Route::put('/events/{id}', [FrontTeacherController::class, 'event_edit'])->name('teacher.events-edit');
        Route::get('/events/{id}/edit', [FrontTeacherController::class, 'event_edit_view'])->name('teacher.events-edit-show');
        Route::post('/events', [FrontTeacherController::class, 'event_save'])->name('teacher.events-save');
        Route::get('/events', [FrontTeacherController::class, 'events'])->name('teacher.events');

        Route::get('/pay', [FrontTeacherController::class, 'payments'])->name('teacher.pay');

        Route::post('/reports', [FrontTeacherController::class, 'show_reports'])->name('teacher.reports-show');
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

        Route::put('/teacher/assign/{id}', [TeacherController::class, 'assign_student'])->name('assign.teacher');
        Route::delete('/teacher/payment/{id}', [TeacherController::class, 'del_payment'])->name('pay-del.teacher');
        Route::put('/teacher/payment/{teacher}', [TeacherController::class, 'payments'])->name('pay.teacher');
        Route::put('/teacher/payment-update/{id}', [TeacherController::class, 'pay_update'])->name('pay-update.teacher');
        Route::resource('/teacher', TeacherController::class);
        Route::resource('/orders', OrderController::class);

        Route::post('/reports/sells', [ReportController::class, 'sells_reports'])->name('admin.reports-sells');
        Route::post('/reports/payments', [ReportController::class, 'payment_reports'])->name('admin.reports-pay');
        Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');

        Route::post('/reports/time', [ReportController::class, 'time_report'])->name('admin.time-log');
        Route::get('/reports/time', [ReportController::class, 'times'])->name('admin.time');
    });
});





/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');*/
