<?php

namespace App\Http\Controllers\restaurantsControllers;

use Illuminate\Support\Facades\Route;

Route::prefix('restaurant')->group(function() {
    Route::get('/login', [AuthController::class, 'index'])->name('restaurant.login');
    Route::post('/login', [AuthController::class, 'login'])->name('restaurant.login');
    Route::get('/forgot-password', [AuthController::class, 'password_forgot'])->middleware('guest')->name('restaurant.pwforgot');
    Route::post('/forgot-password', [AuthController::class, 'update'])->middleware('guest')->name('restaurant.pwforgot');
    Route::middleware('auth.restaurant')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('restaurant.logout');
        Route::get('/', [AuthController::class, 'home'])->name('restaurant.home');
    });
    Route::resource('categoriesMeals',categoriesMealsController::class);
    Route::resource('dishes',dishController::class);
    Route::resource('menu',menuController::class);
    Route::resource('schedules', SchedulesController::class);
});
