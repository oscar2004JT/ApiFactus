<?php

use App\Http\Controllers\Factus\AuthFactusController;
use App\Http\Controllers\Factus\BillsController;
use App\Http\Controllers\Factus\FactusResourcesController;
use App\Http\Controllers\Factus\NumberingRangesController;
use Illuminate\Support\Facades\Route;

Route::prefix('factus')->name('factus.')->group(function () {
    Route::post('/token', [AuthFactusController::class, 'token'])->name('token');

    Route::get('/bills', [BillsController::class, 'index'])->name('bills.index');
    Route::get('/bills/{number}', [FactusResourcesController::class, 'bill'])->name('bills.show');
    Route::get('/bills/{number}/download-pdf', [FactusResourcesController::class, 'billPdf'])->name('bills.pdf');
    Route::get('/bills/{number}/download-xml', [FactusResourcesController::class, 'billXml'])->name('bills.xml');
    Route::get('/bills/{number}/download-xml-attached-document', [FactusResourcesController::class, 'billAttachedDocument'])->name('bills.attached-document');
    Route::get('/bills/{number}/radian/events', [FactusResourcesController::class, 'billEvents'])->name('bills.events');
    Route::post('/bills/{number}/send-email', [FactusResourcesController::class, 'sendBillEmail'])->name('bills.send-email');
    Route::post('/bills/validate', [BillsController::class, 'validateBill'])->name('bills.validate');

    Route::get('/numbering-ranges', [NumberingRangesController::class, 'index'])->name('numbering-ranges.index');

    Route::get('/credit-notes', [FactusResourcesController::class, 'creditNotes'])->name('credit-notes.index');
    Route::get('/support-documents', [FactusResourcesController::class, 'supportDocuments'])->name('support-documents.index');
    Route::get('/companies', [FactusResourcesController::class, 'company'])->name('companies.show');
});
