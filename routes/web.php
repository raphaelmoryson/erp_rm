<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PropertiesController;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [IndexController::class, 'index']);

    Route::get('/properties', [PropertiesController::class,'index'])->name('properties');
    Route::get('/properties/create', [PropertiesController::class,'create'])->name('properties.create');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

