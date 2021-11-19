<?php

use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\TokenController;
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

Route::get('/', function () {
    return response()->json("hello-world");
});

Route::resource('/register', RegistrationController::class)->only(['store']);
Route::resource('/token', TokenController::class)->only(['store', 'update']);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
