<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\SessionController;
use App\Models\Appointment;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PlanTypeController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('test', function () {
    return view('test');
});

Route::get('/appointments',[AppointmentController::class,'index']);
Route::get('/appointments/update_status/{id}/{type}',[AppointmentController::class,'updateStatus']);
Route::get('/appointments/search',[AppointmentController::class,'search'])->name('appointment.search');

Route::resource('sessions',SessionController::class);

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::resource('plans',PlanController::class);
Route::resource('plan_types',PlanTypeController::class);
Route::get('/search',[PlanController::class,'search'])->name("plans.search");