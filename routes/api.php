<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingRecordController;
use App\Http\Controllers\VacancyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function() {
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/register', [AuthController::class, 'registerCustomer']);
    Route::post('/auth/register/admin', [AuthController::class, 'registerAdmin']);
    Route::post('/auth/register/trainer', [AuthController::class, 'registerTrainer']);
    
    Route::middleware('auth:api')->group(function() {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [CustomerController::class, 'getDataProfile']);
        Route::put('/profile/edit', [CustomerController::class, 'updateProfile']);
        Route::post('/profile/avatar/edit', [CustomerController::class, 'updateProfilePicture']);
        Route::get('/admin/profile', [AdminController::class, 'getAdminProfile']);
        Route::post('/admin/profile', [AdminController::class, 'editAdminProfile']);

        Route::get('/trainer/profile', [TrainerController::class, 'getTrainerProfile']);
        Route::post('/trainer/profile', [TrainerController::class, 'editAdminProfile']);
        Route::post('/trainer/profile/image', [TrainerController::class, 'editProfileImage']);
        Route::post('/trainer/profile/cv', [TrainerController::class, 'editCv']);
        Route::post('/trainer/upload_material/{id}', [TrainerController::class, 'uploadMaterial']);

        // Trainings route
        Route::get('/trainings', [TrainingController::class, 'index']);
        Route::get('/training/{id}', [TrainingController::class, 'show']);
        Route::post('/training', [TrainingController::class, 'store']);
        Route::put('/trainings/{id}', [TrainingController::class, 'update']);
        Route::delete('/training/{id}', [TrainingController::class, 'destroy']);
        Route::post('/training/register', [TrainingController::class, 'registerTraining']);
        Route::get('/admin/trainings', [TrainingController::class, 'getTrainings']);
        Route::get('/admin/training/{id}', [TrainingController::class, 'getDetailTraining']);
        Route::get('/admin/training_records', [TrainingController::class, 'getTrainingRecords']);
        Route::get('/trainer/trainings', [TrainingController::class, 'getTrainingForTrainer']);

        // Invoice
        Route::get('/invoices', [InvoiceController::class, 'index']);
        Route::get('/invoice/{id}', [InvoiceController::class, 'show']);
        Route::delete('/invoice/{id}', [InvoiceController::class, 'destroy']);
        
        Route::get('/trainers', [TrainerController::class, 'index']);
        Route::get('/trainer/{id}', [TrainerController::class, 'show']);
        Route::post('/trainer/{id}', [TrainerController::class, 'update']);
        Route::delete('/trainer/{id}', [TrainerController::class, 'destroy']);

        // Vacancy
        Route::get('/vacancies', [VacancyController::class, 'index']);
        Route::get('/vacancy/{id}', [VacancyController::class, 'show']);
        Route::post('/vacancy', [VacancyController::class, 'store']);
        Route::put('/vacancy/{id}', [VacancyController::class, 'update']);
        Route::delete('/vacancy/{id}', [VacancyController::class, 'destroy']);
        
        Route::get('/followup_trainings', [TrainingRecordController::class, 'getCustomerTrainingRecords']);
        Route::get('/followup_training/{id}', [TrainingRecordController::class, 'showCustomerTrainingRecord']);
        Route::post('/training/requirements', [TrainingRecordController::class, 'uploadTrainingRequirements']);
        
        Route::get('/training_record/customers/{id}', [TrainingRecordController::class, 'getTrainingCustomers']);
        Route::post('/training_record/competence_certificate/{id}', [TrainingRecordController::class, 'uploadCompetenceCertificate']);
        Route::post('/training_record/training_certificate/{id}', [TrainingRecordController::class, 'uploadTrainingCertificate']);

        // Admin
        Route::get('/customers', [CustomerController::class, 'index']);
        Route::get('/customer/{id}', [CustomerController::class, 'show']);
        Route::delete('/customer/{id}', [CustomerController::class, 'destroy']);

        // Dashboard
        Route::get('/admin/dashboard', [DashboardController::class, 'statistic']);
    });
    Route::post('/logintest', [AuthController::class, 'loginTest']);
    Route::get('/test', [AuthController::class, 'test']);
    // Route::get('/admin/trainings', [TrainingController::class, 'getTrainings']);
});
