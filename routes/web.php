<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LegalDocumentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PartnerDocumentController;
use App\Http\Controllers\EmployeeLegalController;
use App\Http\Controllers\EmployeeDocumentController;
use App\Http\Controllers\ManagementDocumentController;
use App\Http\Controllers\ModulePinController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Module PIN Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/module-pin/verify', [ModulePinController::class, 'verify'])->name('module-pin.verify');
    Route::post('/module-pin/change', [ModulePinController::class, 'changePin'])->name('module-pin.change');
    Route::get('/module-pin/check', [ModulePinController::class, 'checkAccess'])->name('module-pin.check');
});

Route::middleware(['auth'])->group(function () {
    // Legal Documents Routes (PIN protected)
    Route::middleware(['module.pin:legal-documents'])->group(function () {
        Route::post('/legal-documents/create-folder', [LegalDocumentController::class, 'createFolder'])
            ->name('legal-documents.createFolder');
        Route::get('/legal-documents', [LegalDocumentController::class, 'index'])
            ->name('legal-documents.index');
        Route::post('/legal-documents', [LegalDocumentController::class, 'store'])
            ->name('legal-documents.store');
        Route::get('/legal-documents/{folder}/files', [LegalDocumentController::class, 'getDocuments'])
            ->where('folder', '[^/]+')
            ->name('legal-documents.files');
        Route::post('/legal-documents/{folder}/upload', [LegalDocumentController::class, 'storeDocument'])
            ->where('folder', '[^/]+')
            ->name('legal-documents.upload');
        Route::post('/legal-documents/{folder}/delete', [LegalDocumentController::class, 'deleteFile'])
            ->where('folder', '[^/]+')
            ->name('legal-documents.delete');
        Route::get('/legal-documents/{folder}/preview/{filename}', [LegalDocumentController::class, 'previewFile'])
            ->where('filename', '.*');
        Route::post('/legal-documents/rename-folder', [LegalDocumentController::class, 'renameFolder'])
            ->name('legal-documents.rename-folder');
        Route::post('/legal-documents/delete-folder', [LegalDocumentController::class, 'deleteFolder'])
            ->name('legal-documents.delete-folder');
        Route::delete('/legal-documents/{legalDocument}', [LegalDocumentController::class, 'destroy'])
            ->name('legal-documents.destroy');
    });

    // Inventory Routes (PIN protected)
    Route::middleware(['module.pin:inventory'])->group(function () {
        Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('/inventory/register', [InventoryController::class, 'register'])->name('inventory.register');
        Route::get('/inventory/audit-trail', [InventoryController::class, 'auditTrail'])->name('inventory.audit-trail');
        Route::get('/inventory/assets', [InventoryController::class, 'getAssets'])->name('inventory.assets');
        Route::get('/inventory/{id}', [InventoryController::class, 'getAsset'])->name('inventory.show');
        Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
        Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
        Route::delete('/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
        Route::post('/inventory/{id}/loan', [InventoryController::class, 'loan'])->name('inventory.loan');
        Route::post('/inventory/{id}/return', [InventoryController::class, 'returnAsset'])->name('inventory.return');
    });

    // Partner Documents Routes (PIN protected)
    Route::middleware(['module.pin:partner-documents'])->group(function () {
        Route::get('/partner-documents', [PartnerDocumentController::class, 'index'])->name('partner-documents.index');
        Route::post('/partner-documents/category/create', [PartnerDocumentController::class, 'createCategory'])->name('partner-documents.category.create');
        Route::post('/partner-documents/category/rename', [PartnerDocumentController::class, 'renameCategory'])->name('partner-documents.category.rename');
        Route::post('/partner-documents/category/delete', [PartnerDocumentController::class, 'deleteCategory'])->name('partner-documents.category.delete');
        Route::post('/partner-documents/document/{documentId}/delete', [PartnerDocumentController::class, 'deleteDocument'])->name('partner-documents.document.delete');
        Route::post('/partner-documents/document/{documentId}/update', [PartnerDocumentController::class, 'updateDocument'])->name('partner-documents.document.update');
        Route::get('/partner-documents/preview/{documentId}', [PartnerDocumentController::class, 'previewDocument'])->name('partner-documents.preview');
        Route::get('/partner-documents/download/{documentId}', [PartnerDocumentController::class, 'downloadDocument'])->name('partner-documents.download');
        Route::get('/partner-documents/partners', [PartnerDocumentController::class, 'getPartners'])->name('partner-documents.partners.index');
        Route::post('/partner-documents/partners', [PartnerDocumentController::class, 'storePartner'])->name('partner-documents.partners.store');
        Route::get('/partner-documents/partners/{id}', [PartnerDocumentController::class, 'getPartner'])->name('partner-documents.partners.show');
        Route::put('/partner-documents/partners/{id}', [PartnerDocumentController::class, 'updatePartner'])->name('partner-documents.partners.update');
        Route::delete('/partner-documents/partners/{id}', [PartnerDocumentController::class, 'deletePartner'])->name('partner-documents.partners.destroy');
        Route::post('/partner-documents/partners/{id}/activate', [PartnerDocumentController::class, 'activatePartner'])->name('partner-documents.partners.activate');
        Route::post('/partner-documents/partners/{id}/suspend', [PartnerDocumentController::class, 'suspendPartner'])->name('partner-documents.partners.suspend');
        Route::get('/partner-documents/revenues', [PartnerDocumentController::class, 'getRevenues'])->name('partner-documents.revenues.index');
        Route::post('/partner-documents/revenues', [PartnerDocumentController::class, 'storeRevenue'])->name('partner-documents.revenues.store');
        Route::put('/partner-documents/revenues/{id}', [PartnerDocumentController::class, 'updateRevenue'])->name('partner-documents.revenues.update');
        Route::delete('/partner-documents/revenues/{id}', [PartnerDocumentController::class, 'deleteRevenue'])->name('partner-documents.revenues.destroy');
        Route::get('/partner-documents/analytics', [PartnerDocumentController::class, 'getAnalytics'])->name('partner-documents.analytics');
        Route::get('/partner-documents/{categoryId}/documents', [PartnerDocumentController::class, 'getDocuments'])->name('partner-documents.documents');
        Route::post('/partner-documents/{categoryId}/upload', [PartnerDocumentController::class, 'uploadDocument'])->name('partner-documents.upload');
    });

    // Employee Legal / Kontrak Karyawan Routes (PIN protected)
    Route::middleware(['module.pin:employee-legal'])->group(function () {
        Route::get('/employee-legal', [EmployeeLegalController::class, 'index'])->name('employee-legal.index');
        Route::post('/employee-legal', [EmployeeLegalController::class, 'store'])->name('employee-legal.store');
        Route::get('/employee-legal/contracts', [EmployeeLegalController::class, 'getContracts'])->name('employee-legal.contracts');
        Route::get('/employee-legal/{id}', [EmployeeLegalController::class, 'show'])->name('employee-legal.show');
        Route::put('/employee-legal/{id}', [EmployeeLegalController::class, 'update'])->name('employee-legal.update');
        Route::delete('/employee-legal/{id}', [EmployeeLegalController::class, 'destroy'])->name('employee-legal.destroy');
    });

    // Employee Documents / Legal Karyawan Routes (PIN protected)
    Route::middleware(['module.pin:employee-documents'])->group(function () {
        Route::get('/employee-documents', [EmployeeDocumentController::class, 'index'])->name('employee-documents.index');
        Route::post('/employee-documents/employees', [EmployeeDocumentController::class, 'storeEmployee'])->name('employee-documents.employees.store');
        Route::put('/employee-documents/employees/{id}', [EmployeeDocumentController::class, 'updateEmployee'])->name('employee-documents.employees.update');
        Route::delete('/employee-documents/employees/{id}', [EmployeeDocumentController::class, 'destroyEmployee'])->name('employee-documents.employees.destroy');
        Route::get('/employee-documents/{employeeId}/files', [EmployeeDocumentController::class, 'getFiles'])->name('employee-documents.files');
        Route::post('/employee-documents/{employeeId}/upload', [EmployeeDocumentController::class, 'uploadFile'])->name('employee-documents.upload');
        Route::delete('/employee-documents/files/{fileId}', [EmployeeDocumentController::class, 'deleteFile'])->name('employee-documents.files.delete');
        Route::get('/employee-documents/preview/{fileId}', [EmployeeDocumentController::class, 'previewFile'])->name('employee-documents.preview');
    });

    // Management Documents / Legal Management Routes (PIN protected)
    Route::middleware(['module.pin:management-documents'])->group(function () {
        Route::get('/management-documents', [ManagementDocumentController::class, 'index'])->name('management-documents.index');
        Route::post('/management-documents/profiles', [ManagementDocumentController::class, 'storeProfile'])->name('management-documents.profiles.store');
        Route::put('/management-documents/profiles/{id}', [ManagementDocumentController::class, 'updateProfile'])->name('management-documents.profiles.update');
        Route::delete('/management-documents/profiles/{id}', [ManagementDocumentController::class, 'destroyProfile'])->name('management-documents.profiles.destroy');
        Route::get('/management-documents/{profileId}/files', [ManagementDocumentController::class, 'getFiles'])->name('management-documents.files');
        Route::post('/management-documents/{profileId}/upload', [ManagementDocumentController::class, 'uploadFile'])->name('management-documents.upload');
        Route::delete('/management-documents/files/{fileId}', [ManagementDocumentController::class, 'deleteFile'])->name('management-documents.files.delete');
        Route::get('/management-documents/preview/{fileId}', [ManagementDocumentController::class, 'previewFile'])->name('management-documents.preview');
    });
});






require __DIR__ . '/auth.php';
