<?php

use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\NurseController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\PrescriptionController;
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

    Route::prefix('patient')->name('patient.')->group(function () {
        Route::get('/', [PatientController::class, 'index'])->name('index');
        Route::get('/me', [PatientController::class, 'show'])->name('me.show');
        Route::match(['put', 'patch'], '/', [PatientController::class, 'update'])->name('update');

        Route::get('/doctor', [PatientController::class, 'doctorIndex'])->name('doctor.show');
        Route::get('/nurse', [PatientController::class, 'nurseIndex'])->name('nurse.show');
        Route::post('/doctor/{doctor}', [PatientController::class, 'attachDoctor'])->name('doctor.attach');
        Route::post('/nurse/{nurse}', [PatientController::class, 'attachNurse'])->name('nurse.attach');
    });

    Route::prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/', [DoctorController::class, 'index'])->name('index');
        Route::match(['put', 'patch'], '/', [DoctorController::class, 'update'])->name('update');
        Route::get('/{doctor}/image', [DoctorController::class, 'imageShow'])->name('image.show');
        Route::get('/{doctor}', [DoctorController::class, 'show'])->name('show');
    });

    Route::prefix('nurse')->name('nurse.')->group(function () {
        Route::get('/', [NurseController::class, 'index'])->name('index');
        Route::match(['put', 'patch'], '/', [NurseController::class, 'update'])->name('update');
        Route::get('/{nurse}/image', [NurseController::class, 'imageShow'])->name('image.show');
        Route::get('/{nurse}', [NurseController::class, 'show'])->name('show');
    });

    Route::prefix('pharmacist')->name('pharmacist.')->group(function () {
        Route::get('/', [PharmacistController::class, 'index'])->name('index');
        Route::get('/{pharmacist}', [PharmacistController::class, 'show'])->name('show');
    });

    Route::prefix('document')->name('document.')->group(function () {
        Route::post('/', [DocumentController::class, 'store'])->name('store');
        Route::match(['put', 'patch'], '/{document}', [DocumentController::class, 'adminUpdate'])->name('update');
        Route::get('/{document}', [DocumentController::class, 'show'])->name('show');
        Route::get('/{document}/download', [DocumentController::class, 'download'])->name('download');
    });

    Route::prefix('prescription')->name('prescription.')->group(function () {
        Route::post('/patient/{patient}', [PrescriptionController::class, 'store'])->name('store');
        Route::get('/', [PrescriptionController::class, 'index'])->name('index');
//        Route::get('/{pharmacist}', [PharmacistController::class, 'show'])->name('show');
    });

});

