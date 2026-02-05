<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LegalDocumentController;
use App\Http\Controllers\InventoryController;

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
});






require __DIR__ . '/auth.php';
