<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\TechnicalFileController;
use App\Http\Controllers\TechnicalFolderController;
use App\Http\Controllers\TenantsController;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [IndexController::class, 'index']);

    Route::get('/properties', [PropertiesController::class, 'index'])->name('properties');
    Route::get('/properties/edit/{id}', [PropertiesController::class, 'show'])->name('properties.show');
    Route::get('/properties/create', [PropertiesController::class, 'create'])->name('properties.create');
    Route::post('/properties/create', [PropertiesController::class, 'create_post'])->name('properties.create_post');
    Route::get('/properties/tenants/create/{id}', [PropertiesController::class, 'tenants_add'])->name('properties.tenants_add');
    Route::post('/properties/tenants/create/{id}', [PropertiesController::class, 'tenants_post'])->name('properties.tenants_post');
    // PROPERTIES / UNITS
    Route::post('/properties/delete/units/{id}', [PropertiesController::class, 'units_delete'])->name('properties.units_delete');

    Route::get('/properties/units/{id}', [PropertiesController::class, 'show_units'])->name('properties.show_units');

    // PROPERTIES / TEHCNIQUE

    Route::post('/technical_folders/{building}', [TechnicalFolderController::class, 'store'])->name('technical_folders.store');
    Route::post('/technical_files/{folder}', [TechnicalFileController::class, 'store'])->name('technical_files.store');
    Route::delete('/technical_files/{file}', [TechnicalFileController::class, 'destroy'])->name('technical_files.delete');


    // TENANTS

    Route::get("tenants", [TenantsController::class, "index"])->name('tenants');

});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

