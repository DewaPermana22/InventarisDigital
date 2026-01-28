<?php

namespace App\Filament\Exports;

use App\Models\PeminjamanBarang;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Carbon\Carbon;

class RiwayatPeminjamanExporter extends Exporter
{
    protected static ?string $model = PeminjamanBarang::class;

    /**
     * Filter data berdasarkan user login
     */
    public static function modifyQuery(Builder $query): Builder
    {
        return $query->where('peminjaman', Auth::id());
    }

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('peminjam.name')
                ->label('Nama Peminjam')
                ->formatStateUsing(fn ($state) => $state ?? '-'),

            ExportColumn::make('barang.name')
                ->label('Nama Barang')
                ->formatStateUsing(fn ($state) => $state ?? '-'),

            ExportColumn::make('keperluan')
                ->label('Keperluan')
                ->formatStateUsing(fn ($state) => $state ?? '-'),

            ExportColumn::make('tanggal_pinjam')
                ->label('Tanggal Pinjam')
                ->formatStateUsing(fn ($state) =>
                    $state ? Carbon::parse($state)->format('d-m-Y') : '-'
                ),

            ExportColumn::make('tanggal_kembali')
                ->label('Tanggal Kembali')
                ->formatStateUsing(fn ($state) =>
                    $state ? Carbon::parse($state)->format('d-m-Y') : '-'
                ),

            ExportColumn::make('status')
                ->label('Status')
                ->formatStateUsing(fn ($state) => $state ?? '-'),

            ExportColumn::make('petugas.name')
                ->label('Petugas')
                ->formatStateUsing(fn ($state) => $state ?? '-'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Export riwayat peminjaman selesai: '
            . Number::format($export->successful_rows)
            . ' baris berhasil diexport.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '
                . Number::format($failedRowsCount)
                . ' baris gagal diexport.';
        }

        return $body;
    }
}
