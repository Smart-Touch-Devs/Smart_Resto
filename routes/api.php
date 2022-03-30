<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\employeesControllers\AccountController;
use App\Http\Controllers\API\employeesControllers\HomeController;
use App\Http\Controllers\API\employeesControllers\ForgotPasswordController;


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


Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::post('/changeData', [AuthController::class, 'changeData']);
    Route::post('/changePassword', [AuthController::class, 'changePassword']);
    Route::post('/changeProfile', [AuthController::class, 'upload']);
    Route::post('/logout',[AuthController::class, 'logout']);
    Route::resource('/account', AccountController::class); //pour voir les details d'un restaurant
    Route::get('/search',[HomeController::class, 'search']);//pour la recherche
});

// Route::post('/changeEmail', [AuthController::class, 'changeEmail']);
Route::get('/restaurants', [AccountController::class, 'restaurants']);
Route::post("/login",[AuthController::class,'login']);
Route::post('/check_code', [AuthController::class, 'checkCode']);
Route::resource('/', HomeController::class);
Route::post('/forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm']);
Route::post('/reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm']);
