<?php

namespace App\Http\Controllers\restaurantsControllers;

use Illuminate\Support\Facades\Route;

Route::prefix('restaurant')->group(function() {
    Route::get('/login', [AuthController::class, 'index'])->name('restaurant.login');
    Route::post('/login', [AuthController::class, 'login'])->name('restaurant.login');
    Route::get('/forgot-password', [AuthController::class, 'password_forgot'])->middleware('guest')->name('restaurant.pwforgot');
    Route::get('/reset-password', [AuthController::class, 'reset_password'])->name('resetPassword');
    Route::post('/resetPassword',[AuthController::class,'resetPassword'])->name('restaurant.resetPassword');
    Route::post('/forgot-password', [AuthController::class, 'update'])->middleware('guest')->name('restaurant.pwforgot');
    Route::middleware('auth.restaurant')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('restaurant.logout');
        Route::get('/', [AuthController::class, 'home'])->name('restaurant.home');
        Route::get('/commands',[CommandController::class,'commandList'])->name('org.commands');
        Route::get('/validateCommand/{id}',[CommandController::class,'validateCommande'])->name('org.validateCommande');
        Route::get('/deleteCommand/{id}',[CommandController::class,'deleteCommande'])->name('restaurant.deleteCommande');
        Route::get('/deleteValidateCommand/{id}',[CommandController::class,'deleteValidateCommande'])->name('restaurant.deleteValidateCommande');
    });
    Route::resource('categoriesMeals',categoriesMealsController::class);
    Route::resource('dishes',dishController::class);
    Route::resource('menu',menuController::class);
    Route::resource('schedules', SchedulesController::class);
});
