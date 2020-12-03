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


Route::post('/login', [\App\Http\Controllers\api\AuthApiController::class,'login']);

Route::get('/receipt',[\App\Http\Controllers\api\ApiReceiptsController::class,'index'])->middleware('auth:api');


Route::get('/receipt/{receipt}',[\App\Http\Controllers\api\ApiReceiptsController::class,'show'])->middleware('auth:api');

Route::post('/receipt/accept',[\App\Http\Controllers\api\ApiReceiptsController::class,'accept'])->middleware('auth:api');
Route::post('/receipt/refuse',[\App\Http\Controllers\api\ApiReceiptsController::class,'refuse'])->middleware('auth:api');
Route::post('/receipt/fcm',[\App\Http\Controllers\api\ApiReceiptsController::class,'fcm'])->middleware('auth:api');
Route::get('/receipt/myInfo',[\App\Http\Controllers\api\ApiReceiptsController::class,'myInfo'])->middleware('auth:api');

