<?php

use App\Http\Controllers\Excel\ExportBarang;
use App\Http\Controllers\Excel\ExportDataPeminjaman;
use App\Http\Controllers\Excel\ExportLaporanPeminjaman;
use App\Http\Controllers\Excel\ExportUserAccount;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\Pdf\GenerateBarcodeBarang;
use App\Http\Controllers\Pdf\GenerateKartuPeminjam;
use Illuminate\Support\Facades\Storage;

Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/scan', [LandingPageController::class, 'scan'])->name('scan');

Route::get('/card', [LandingPageController::class, 'card'])->name('card');

Route::get('/kartu/download', [GenerateKartuPeminjam::class, 'download'])
    ->name('kartu.download');

Route::prefix('barcode')->name('barcode.')->group(function () {
    Route::get('/download', [GenerateBarcodeBarang::class, 'download'])->name('download');
});

//Excel Routes
Route::prefix('export')->name('export.')->group(function () {
    Route::get('/riwayat-peminjaman', [ExportDataPeminjaman::class, 'export'])->name('riwayat-peminjaman');
    Route::get('/users', [ExportUserAccount::class, 'export'])->name('users');
    Route::get('/barangs', [ExportBarang::class, 'export'])->name('barangs');
    Route::get('/laporan-peminjaman', [ExportLaporanPeminjaman::class, 'export'])->name('laporan-peminjaman');
});
