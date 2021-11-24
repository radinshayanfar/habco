<?php

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
    Route::post('/user', [UserController::class, 'store']);
    // Send OTP route
    Route::resource('/login-token', LoginTokenController::class)->only('store');

});

Route::middleware(['auth:sanctum', 'ability:login'])->group(function () {
    // Login route
    Route::post('/token', [TokenController::class, 'store']);

});

Route::middleware(['auth:sanctum', 'ability:enter-app'])->group(function () {
    // Logout route
    Route::delete('/token', [TokenController::class, 'destroy']);
    Route::get('/user', [UserController::class, 'show']);
});

