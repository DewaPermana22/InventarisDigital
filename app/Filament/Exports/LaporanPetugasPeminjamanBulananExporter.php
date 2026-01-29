<?php

namespace App\Filament\Exports;

use App\Models\PeminjamanBarang;
use Carbon\Carbon;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;

class LaporanPetugasPeminjamanBulananExporter extends Exporter
{
    protected static ?string $model = PeminjamanBarang::class;

    // Menambahkan kolom yang ingin diekspor
    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')->label('ID Peminjaman'),
            ExportColumn::make('peminjam.name')->label('Nama Peminjam'),
            ExportColumn::make('barang.kode_barang')->label('Kode Barang'),
            ExportColumn::make('barang.name')->label('Nama Barang'),
            ExportColumn::make('keperluan')->label('Keperluan'),
            ExportColumn::make('tanggal_pinjam')->label('Tanggal Pinjam'),
            ExportColumn::make('tanggal_kembali')->label('Tanggal Kembali'),
            ExportColumn::make('tanggal_disetujui')->label('Tanggal Disetujui'),
            ExportColumn::make('status')->label('Status'),
        ];
    }

    public static function getQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $now = Carbon::now();

        return PeminjamanBarang::query()
            ->with(['peminjam', 'barang', 'petugas'])
            ->where('petugas_id', Auth::id())
            ->whereYear('tanggal_disetujui', $now->year)
            ->whereMonth('tanggal_disetujui', $now->month);
    }

    // Notifikasi
    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Laporan peminjaman yang Anda ACC telah selesai diekspor dan '
            . Number::format($export->successful_rows) . ' '
            . str('row')->plural($export->successful_rows) . ' berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' '
                . str('row')->plural($failedRowsCount) . ' gagal diekspor.';
        }

        return $body;
    }
}
