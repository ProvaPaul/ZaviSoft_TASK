<?php

<<<<<<< HEAD
use Illuminate\Http\Request;
=======
use App\Http\Controllers\Api\UserController;
>>>>>>> 10c2979b2be322958648dcb15add19f1013cb4ff
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

<<<<<<< HEAD
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
=======
Route::middleware('auth:api')->get('/user', [UserController::class, 'show']);
>>>>>>> 10c2979b2be322958648dcb15add19f1013cb4ff
