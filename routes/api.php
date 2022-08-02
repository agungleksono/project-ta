<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TrainingController;
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
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'registerCustomer']);
    
    Route::middleware('auth:api')->group(function() {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile/{id}', [CustomerController::class, 'getDataProfile']);
        Route::put('/profile/edit', [CustomerController::class, 'updateProfile']);
        Route::post('/profile/avatar/edit', [CustomerController::class, 'updateProfilePicture']);

        // Trainings route
        Route::get('/trainings', [TrainingController::class, 'index']);
        Route::get('/trainings/{id}', [TrainingController::class, 'show']);
        Route::post('/trainings', [TrainingController::class, 'store']);
        Route::put('/trainings/{id}', [TrainingController::class, 'update']);
        Route::delete('/trainings/{id}', [TrainingController::class, 'destroy']);
        Route::get('/test', [AuthController::class, 'test']);
    });
    Route::post('/trainings/register', [TrainingController::class, 'registerTraining']);
});
