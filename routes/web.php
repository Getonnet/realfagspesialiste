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
    Route::post('/my-order', [FrontStudentController::class, 'orders_save'])->name('package.orders');
    Route::get('/my-order', [FrontStudentController::class, 'orders'])->name('order.list');

    Route::get('/my-reports', [FrontStudentController::class, 'reports'])->name('my.reports');
    Route::get('/my-profile', [FrontStudentController::class, 'profile'])->name('my.profile');
    Route::put('/my-profile/{id}', [FrontStudentController::class, 'update_profile'])->name('update.myprofile');
});


Route::prefix('teacher')->group(function () {
    Route::get('/register', [FrontTeacherController::class, 'register'])->name('teacher.register');

    Route::middleware(['auth', 'teacher'])->group(function () {
        Route::get('/', [FrontTeacherController::class, 'index'])->name('teacher.home');
        Route::get('/profile', [FrontTeacherController::class, 'profile'])->name('teacher.profile');
        Route::put('/profile/{id}', [FrontTeacherController::class, 'update_profile'])->name('update.teacher_profile');

        Route::put('/events/{id}', [FrontTeacherController::class, 'event_edit'])->name('teacher.events-edit');
        Route::post('/events', [FrontTeacherController::class, 'event_save'])->name('teacher.events-save');
        Route::get('/events', [FrontTeacherController::class, 'events'])->name('teacher.events');

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
        Route::resource('/teacher', TeacherController::class);
        Route::resource('/orders', OrderController::class);
    });
});





/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');*/
