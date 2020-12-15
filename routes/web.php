<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MyReceiptsController;
use App\Http\Controllers\ReceiptsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');



Route::group(['middleware' => ['auth:sanctum']],function (){
    Route::resource('companies',CompanyController::class);
    Route::resource('user',UserController::class);
    Route::resource('MyReceipt',MyReceiptsController::class);

    Route::get('/downloadFile',[\App\Http\Controllers\FileDownloader::class,'download'])->name('downloadFile');

});


Route::group(['middleware' => ['auth:sanctum','isManager']],function (){

    //Route::resource('receipt',ReceiptsController::class);
    Route::post('/accept',[MyReceiptsController::class,'accept'])->name('accept');
    Route::post('/refuse',[MyReceiptsController::class,'refuse'])->name('refuse');

});



