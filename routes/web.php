<?php

use App\Http\Controllers\DashboardController;
//use App\Http\Controllers\MainController;
use App\Http\Controllers\Orders\OrderController;
use App\Http\Controllers\Packages\PackagesController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Subjects\SubjectsController;
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

Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::put('/permissions/{id}', [RolesController::class, 'assign_role'])->name('permissions');
    Route::resource('/users/roles', RolesController::class);
    Route::resource('/users', UserController::class);

    Route::resource('/subjects', SubjectsController::class);
    Route::resource('/package', PackagesController::class);

    Route::resource('/student', StudentController::class);
    Route::resource('/teacher', TeacherController::class);
    Route::resource('/orders', OrderController::class);
});



/*
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');*/
