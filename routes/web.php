<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Pdf\GenerateBarcodeBarang;
use App\Http\Controllers\Pdf\GenerateKartuPeminjam;

Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/scan', [LandingPageController::class, 'scan'])->name('scan');

Route::get('/card', [LandingPageController::class, 'card'])->name('card');
Route::get('/pricing', [LandingPageController::class, 'pricing'])->name('pricing');

Route::get('/kartu/download', [GenerateKartuPeminjam::class, 'download'])
    ->name('kartu.download');

Route::prefix('barcode')->name('barcode.')->group(function () {
    // Download PDF (mirip dengan download kartu)
    Route::get('/download', [GenerateBarcodeBarang::class, 'download'])->name('download');
    // Download single barcode sebagai PNG
    Route::get('/download-image/{kodeBarang}', [GenerateBarcodeBarang::class, 'downloadImage'])->name('download-image');
});
