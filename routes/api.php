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


Route::get('/receipt',[\App\Http\Controllers\api\ApiReceiptsController::class,'index']);


Route::get('/receipt/{receipt}',[\App\Http\Controllers\api\ApiReceiptsController::class,'show']);

Route::post('/receipt/accept',[\App\Http\Controllers\api\ApiReceiptsController::class,'accept']);
Route::post('/receipt/refuse',[\App\Http\Controllers\api\ApiReceiptsController::class,'refuse']);

