<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PropertiesController;
use App\Http\Controllers\QrBillController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TechnicalFileController;
use App\Http\Controllers\TechnicalFolderController;
use App\Http\Controllers\TenantsController;
use App\Http\Controllers\UnitController;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Storage;

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


    // UNITS LINK PROERTIES
    Route::get('/properties/show/{properties}/units/{id}', [PropertiesController::class, 'show_units'])->name('properties.show_units');

    Route::post('/unit/{id}/assign-tenant', [UnitController::class, 'assignTenant'])->name('unit.assign_tenant');
    Route::post('/unit/{id}/remove-tenant', [UnitController::class, 'removeTenant'])->name('unit.remove_tenant');

    // PROPERTIES / TEHCNIQUE

    Route::post('/technical_folders/{building}', [TechnicalFolderController::class, 'store'])->name('technical_folders.store');
    Route::post('/technical_files/{folder}', [TechnicalFileController::class, 'store'])->name('technical_files.store');
    Route::delete('/technical_files/{file}', [TechnicalFileController::class, 'destroy'])->name('technical_files.delete');
    Route::delete('/technical_folders/{folder}', [TechnicalFolderController::class, 'destroy'])->name('technical_folder.delete');
    // TENANTS

    Route::get("/tenants", [TenantsController::class, "index"])->name('tenants');
    Route::get("/tenants/create", [TenantsController::class, "create"])->name('tenants.create');
    Route::get("/tenants/edit/{id}", [TenantsController::class, "edit"])->name('tenants.edit');
    Route::put('/tenants/{tenant}', [TenantsController::class, 'update'])->name('tenants.update');

    Route::post('/tenants/store', [TenantsController::class, 'store'])->name('tenants.store');

    // PAYMENTS

    Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
    Route::post('/payments/{id}/mark-as-paid', [PaymentController::class, 'markAsPaid'])->name('payments.markAsPaid');

    // ENTREPRISE LISTE 

    Route::get("/company", [CompanyController::class, "index"])->name('company');

    // REPORT
    Route::post('/report/store', [ReportController::class, 'store'])->name('report.store');
    Route::post('/reports/{id}/toggle', [ReportController::class, 'toggleStatus'])->name('reports.toggle');
    Route::get('/reports/{id}', [ReportController::class, 'show'])->name('reports.show');


    // INVOICE

    Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoice/{id}/pdf', [InvoiceController::class, 'showPdf'])->name('invoice.pdf');

    // INVENTORY / ETAT DES LIEUX

    Route::post('/inventory/store', [InventoryController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/pdf/{id}', [InventoryController::class, 'generatePDF'])->name('inventory.pdf');

    Route::get('/facture-qr', [QrBillController::class, 'generateQrBill']);
    
});
Route::get('/report/{slug}', [ReportController::class, 'report_postfile'])->name('report.post_file');
Route::post('/report/{slug}/accepted', [ReportController::class, 'post_accepted'])->name('report.accepted');
Route::post('/report/{slug}/refused', [ReportController::class, 'post_refused'])->name('report.refused');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/support/{slug}', [SupportController::class, 'create'])->name('support.create');
Route::post('/support/{slug}/send', [SupportController::class, 'send'])->name('support.send');
