<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\Token\LoginTokenController;
use App\Http\Controllers\Token\TokenController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return response()->json("hello-world");
});

Route::middleware('guest:sanctum')->group(function () {
    // Register route
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    // Send OTP route
    Route::apiResource('/login-token', LoginTokenController::class)->only('store');

});

Route::middleware(['auth:sanctum', 'ability:login'])->group(function () {
    // Login route
    Route::post('/token', [TokenController::class, 'store'])->name('token.store');;

});

Route::middleware(['auth:sanctum', 'ability:enter-app'])->group(function () {
    // Logout route
    Route::delete('/token', [TokenController::class, 'destroy'])->name('token.destroy');

    Route::name('user.')->group(function () {
        Route::get('/user', [UserController::class, 'show'])->name('show');;
        Route::match(['put', 'patch'], '/user', [UserController::class, 'update'])->name('update');;
    });

    Route::name('patient.')->group(function () {
        Route::get('/patient', [PatientController::class, 'show'])->name('show');
        Route::match(['put', 'patch'], '/patient', [PatientController::class, 'update'])->name('update');
    });

    Route::name('doctor.')->group(function () {
        Route::get('/doctor', [DoctorController::class, 'index'])->name('index');
        Route::match(['put', 'patch'], '/doctor', [DoctorController::class, 'update'])->name('update');
        Route::get('/doctor/{doctor}/image', [DoctorController::class, 'imageShow'])->name('image.show');
        Route::get('/doctor/{doctor}', [DoctorController::class, 'show'])->name('show');
    });

    Route::name('document.')->group(function () {
        Route::post('/document', [DocumentController::class, 'store'])->name('store');
        Route::match(['put', 'patch'], '/document/{document}', [DocumentController::class, 'adminUpdate'])->name('update');
        Route::get('/document/{document}', [DocumentController::class, 'show'])->name('show');
    });

});

