<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TrainingController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/trainings', [TrainingController::class, 'index']);
// Route::get('/login', [AuthController::class, 'login']);
Route::get('/test', [AuthController::class, 'test']);
Route::get('/dashboard', function() {
    return view('dashboard.index');
});
Route::get('/login', function() {
    return view('login');
})->name('login');
Route::get('/admin', function() {
    return view('dashboard.admins.index');
});
Route::get('/admin/customers', function() {
    return view('dashboard.admins.customer');
})->name('customers');
Route::get('/admin/lowongan-kerja', function() {
    return view('dashboard.admins.vacancy');
})->name('vacancies');
Route::get('/admin/trainer', function() {
    return view('dashboard.admins.trainer');
})->name('trainers');
Route::get('/admin/pelatihan', function() {
    return view('dashboard.admins.training');
})->name('trainings');
