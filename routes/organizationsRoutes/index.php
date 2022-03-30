<?php

use App\Http\Controllers\organizationsControllers\AuthController;
use App\Http\Controllers\organizationsControllers\backgroundController;
use App\Http\Controllers\organizationsControllers\ticketsController;
use App\Http\Controllers\organizationsControllers\GroupController;
use App\Http\Controllers\organizationsControllers\RestaurantController;
use App\Http\Controllers\organizationsControllers\EmployeeController;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Route;

Route::prefix('org')->group(function () {
    Route::get('login', [AuthController::class,'index'])->name('org.login');
    Route::post('login', [AuthController::class,'login'])->name('org.login');
    Route::middleware('auth.org')->group(function () {
        Route::get('/', [AuthController::class, 'home'])->name('org.home');
        Route::post('/logout',[AuthController::class, 'logout'])->name('org.logout');
        Route::resource('tickets',ticketsController::class);
        Route::resource('groups', GroupController::class);
        Route::resource('add_employees', EmployeeController::class);
        Route::resource('org_restaurants', RestaurantController::class);
    });
    Route::post('role/changeStatus', [Restaurant::class, 'changeStatus'])->name('role.changeStatus');
    route::resource('background',backgroundController::class);
    Route::get('password_forgot',[AuthController::class,'password_forgot'])->name('password_forgot');
    Route::post('sendLink',[AuthController::class,'sendLink']);
    Route::get('reset_password/{token}', [AuthController::class, 'reset_password'])->name('reset_password');
    Route::post('submitResetPasswordForm', [AuthController::class, 'submitResetPasswordForm']);
});
