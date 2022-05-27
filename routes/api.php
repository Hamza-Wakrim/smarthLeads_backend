<?php

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

//Route::get('user', [UserAPIController::class, 'user']);

Route::get('user', [\App\Http\Controllers\UserController::class, 'index']);

Route::post('register', [\App\Http\Controllers\Auth\UserAuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\Auth\UserAuthController::class, 'login']);
Route::resource('projects',\App\Http\Controllers\API\ProjectsAPIController::class);



Route::middleware('auth:api')->group(function () {

    Route::get('tickets', [\App\Http\Controllers\API\TicketController::class,'index']);

});
