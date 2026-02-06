<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LegalDocumentController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PartnerDocumentController;

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

Route::middleware(['auth'])->group(function () {
    Route::post('/legal-documents/create-folder', [LegalDocumentController::class, 'createFolder'])
        ->name('legal-documents.createFolder');
    
    Route::get('/legal-documents', [LegalDocumentController::class, 'index'])
        ->name('legal-documents.index');
    
    Route::post('/legal-documents', [LegalDocumentController::class, 'store'])
        ->name('legal-documents.store');
    
    // ✅ Tanpa /folder/ di path
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
        
    // Rename folder
    Route::post('/legal-documents/rename-folder', [LegalDocumentController::class, 'renameFolder'])
        ->middleware('auth')
        ->name('legal-documents.rename-folder');
    
    // Delete folder
    Route::post('/legal-documents/delete-folder', [LegalDocumentController::class, 'deleteFolder'])
        ->middleware('auth')
        ->name('legal-documents.delete-folder');
    
    Route::delete('/legal-documents/{legalDocument}', [LegalDocumentController::class, 'destroy'])
        ->name('legal-documents.destroy');

    // Inventory Routes
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

    // Partner Documents Routes
    Route::get('/partner-documents', [PartnerDocumentController::class, 'index'])->name('partner-documents.index');
    Route::post('/partner-documents/category/create', [PartnerDocumentController::class, 'createCategory'])->name('partner-documents.category.create');
    Route::post('/partner-documents/category/rename', [PartnerDocumentController::class, 'renameCategory'])->name('partner-documents.category.rename');
    Route::post('/partner-documents/category/delete', [PartnerDocumentController::class, 'deleteCategory'])->name('partner-documents.category.delete');
    Route::post('/partner-documents/document/{documentId}/delete', [PartnerDocumentController::class, 'deleteDocument'])->name('partner-documents.document.delete');
    Route::post('/partner-documents/document/{documentId}/update', [PartnerDocumentController::class, 'updateDocument'])->name('partner-documents.document.update');
    Route::get('/partner-documents/preview/{documentId}', [PartnerDocumentController::class, 'previewDocument'])->name('partner-documents.preview');
    Route::get('/partner-documents/download/{documentId}', [PartnerDocumentController::class, 'downloadDocument'])->name('partner-documents.download');

    // Partner Management Routes (integrated from PMS) - MUST be before wildcard {categoryId}
    Route::get('/partner-documents/partners', [PartnerDocumentController::class, 'getPartners'])->name('partner-documents.partners.index');
    Route::post('/partner-documents/partners', [PartnerDocumentController::class, 'storePartner'])->name('partner-documents.partners.store');
    Route::get('/partner-documents/partners/{id}', [PartnerDocumentController::class, 'getPartner'])->name('partner-documents.partners.show');
    Route::put('/partner-documents/partners/{id}', [PartnerDocumentController::class, 'updatePartner'])->name('partner-documents.partners.update');
    Route::delete('/partner-documents/partners/{id}', [PartnerDocumentController::class, 'deletePartner'])->name('partner-documents.partners.destroy');
    Route::post('/partner-documents/partners/{id}/activate', [PartnerDocumentController::class, 'activatePartner'])->name('partner-documents.partners.activate');
    Route::post('/partner-documents/partners/{id}/suspend', [PartnerDocumentController::class, 'suspendPartner'])->name('partner-documents.partners.suspend');

    // Revenue Routes
    Route::get('/partner-documents/revenues', [PartnerDocumentController::class, 'getRevenues'])->name('partner-documents.revenues.index');
    Route::post('/partner-documents/revenues', [PartnerDocumentController::class, 'storeRevenue'])->name('partner-documents.revenues.store');
    Route::put('/partner-documents/revenues/{id}', [PartnerDocumentController::class, 'updateRevenue'])->name('partner-documents.revenues.update');
    Route::delete('/partner-documents/revenues/{id}', [PartnerDocumentController::class, 'deleteRevenue'])->name('partner-documents.revenues.destroy');

    // Analytics Route
    Route::get('/partner-documents/analytics', [PartnerDocumentController::class, 'getAnalytics'])->name('partner-documents.analytics');

    // Wildcard routes LAST (to avoid conflicts)
    Route::get('/partner-documents/{categoryId}/documents', [PartnerDocumentController::class, 'getDocuments'])->name('partner-documents.documents');
    Route::post('/partner-documents/{categoryId}/upload', [PartnerDocumentController::class, 'uploadDocument'])->name('partner-documents.upload');
});






require __DIR__ . '/auth.php';
