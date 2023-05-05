<?php

use App\Http\Controllers\Api\DogsApiController;
use App\Http\Controllers\Api\UserParkController;
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


Route::get('/breeds', [DogsApiController::class, 'index']);
Route::get('/breed/random', [DogsApiController::class, 'show']);
Route::get('/breed/{id}', [DogsApiController::class, 'show']);
Route::put('/breed/{id}', [DogsApiController::class, 'update']);
Route::get('/breed/{image}/image', [DogsApiController::class, 'image']);

Route::delete('/breed/{id}', [DogsApiController::class, 'destroy']);


Route::post('/user/{user_id}/associate', UserParkController::class);
Route::post('/park/{park_id}/breed', [DogsApiController::class, 'associatePark']);
