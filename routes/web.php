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
    return view('login');
    // return view('welcome');
})->name('login');

Route::get('/trainings', [TrainingController::class, 'index']);
// Route::get('/login', [AuthController::class, 'login']);
Route::get('/test', [AuthController::class, 'test']);
Route::get('/dashboard', function() {
    return view('dashboard.index');
});
Route::get('/login', function() {
    return view('login');
});
Route::get('/admin', function() {
    return view('dashboard.admins.index');
});


Route::middleware('token')->group(function() {
    Route::get('/admin/dashboard', function() {
        return view('dashboard.admins.index');
    })->name('admin_dashboard');
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
    Route::get('/admin/riwayat-pelatihan', function() {
        return view('dashboard.admins.training_record');
    })->name('training_records');
    Route::get('/admin/profile', function() {
        return view('dashboard.admins.profile');
    })->name('admin_profile');
    Route::get('/admin/transaksi', function() {
        return view('dashboard.admins.invoice');
    })->name('invoice');
    Route::get('/admin/upload-sertifikat/{id}', function() {
        return view('dashboard.admins.certificate');
    })->name('certificate');
    Route::get('/trainer/dashboard', function() {
        return view('dashboard.trainers.dashboard');
    })->name('trainer_dashboard');
    Route::get('/trainer/pelatihan', function() {
        return view('dashboard.trainers.training');
    })->name('trainer_training');
});
