<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [IndexController::class, 'index']);

    Route::get('/properties', function() {
        $properties = Property::all();
        return view('Page.properties', ['properties' => $properties]);
    });
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

