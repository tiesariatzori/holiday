<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Panel\HomeController;
use App\Http\Controllers\Panel\VacationPlanController;
use App\Http\Controllers\UserController;
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

Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'loginAttempt'])->name('login.attempt');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');

Route::prefix('panel')->middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    /* routes plan */
    route::post('plan/table', [VacationPlanController::class, 'table'])->name('plan.table');
    route::post('plan/export', [VacationPlanController::class, 'table'])->name('plan.export');
    Route::resource('plan', VacationPlanController::class)->parameter('plan', 'vacation_plan');
});
