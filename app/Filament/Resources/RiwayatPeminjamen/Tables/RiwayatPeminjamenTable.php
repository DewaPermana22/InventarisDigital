<?php

namespace App\Filament\Resources\RiwayatPeminjamen\Tables;

use App\Enums\StatusPeminjaman;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class RiwayatPeminjamenTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Riwayat masih kosong')
            ->emptyStateDescription('Belum ada data riwayat peminjaman barang.')
            ->columns([
                TextColumn::make('barang.kode_barang')
                    ->label('Kode Barang')
                    ->weight('bold')
                    ->searchable()
                    ->copyable()
                    ->formatStateUsing(fn($state) => Str::limit($state, 20))
                    ->tooltip(fn($state) => $state)
                    ->copyMessage('Kode barang disalin'),
                TextColumn::make('barang.name')
                    ->label('Barang')
                    ->weight('bold')
                    ->searchable()
                    ->formatStateUsing(fn($state) => Str::limit($state, 20))
                    ->tooltip(fn($state) => $state),
                TextColumn::make('tanggal_pinjam')
                    ->label('Tanggal Pinjam')
                    ->date('d/m/Y'),
                TextColumn::make('tanggal_disetujui')
                    ->label('Tanggal Disetujui')
                    ->date('d/m/Y'),
                TextColumn::make('petugas.name')
                    ->label('Nama Petugas')
                    ->formatStateUsing(fn($state) => Str::limit($state, 20))
                    ->tooltip(fn($state) => $state),
                TextColumn::make('tanggal_kembali')
                    ->label('Tanggal Kembali')
                    ->date('d/m/Y'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(StatusPeminjaman $state) => $state->color())
                    ->formatStateUsing(fn(StatusPeminjaman $state) => $state->label())
                    ->searchable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ]);
    }
}
