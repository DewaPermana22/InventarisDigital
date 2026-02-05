<?php

namespace App\Filament\Resources\MonitoringPeminjamen\Tables;

use App\Enums\StatusPeminjaman;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MonitoringPeminjamenTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->emptyStateHeading('Data Peminjaman Kosong')
            ->emptyStateDescription('Belum ada peminjaman aktif.')
            ->columns([
                TextColumn::make('barang.kode_barang')
                    ->label('Kode Barang')
                    ->searchable()
                    ->copyable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => Str::limit($state, 20))
                    ->weight('bold'),

                TextColumn::make('barang.name')
                    ->label('Barang')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => Str::limit($state, 20))
                    ->weight('bold'),

                TextColumn::make('peminjam.name')
                    ->label('Peminjam')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => Str::limit($state, 20)),

                TextColumn::make('tanggal_kembali')
                    ->label('Tanggal Kembali')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('sisa_waktu')
                    ->label('Sisa Waktu / Denda')
                    ->badge()
                    ->color(function ($record) {
                        if (!$record->tanggal_kembali) return 'gray';

                        $today = now()->startOfDay();
                        $kembali = Carbon::parse($record->tanggal_kembali)->startOfDay();

                        return $today->gt($kembali) ? 'danger' : 'success';
                    })
                    ->getStateUsing(function ($record) {
                        if (!$record->tanggal_kembali) return '-';

                        $today = now()->startOfDay();
                        $kembali = Carbon::parse($record->tanggal_kembali)->startOfDay();

                        $selisih = $today->diffInDays($kembali, true);

                        if ($today->gt($kembali)) {
                            return "Terlambat {$selisih} hari (Denda)";
                        }

                        if ($selisih == 0) {
                            return "Hari ini batas akhir";
                        }

                        return "{$selisih} hari tersisa";
                    }),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Aktif')
                    ->options(function () {
                        $active = StatusPeminjaman::active();
                        $options = [];
                        foreach ($active as $status) {
                            $options[$status->value] = $status->label();
                        }
                        return $options;
                    }),
            ])
            ->defaultSort('tanggal_kembali', 'desc')
            ->striped();
    }
}
