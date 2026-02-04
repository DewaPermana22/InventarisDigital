<?php

namespace App\Filament\Resources\DataPengembalians\Tables;

use App\Enums\StatusPeminjaman;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;

class DataPengembaliansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(null)
            ->emptyStateHeading('Data Pengembalian Kosong')
            ->emptyStateDescription('Belum ada data pengembalian yang tercatat.')
            ->columns([
                ImageColumn::make('barang.foto')
                    ->label('Foto')
                    ->square()
                    ->defaultImageUrl(url('/images/placeholder.png')),

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

                TextColumn::make('tanggal_pinjam')
                    ->label('Tanggal Pinjam')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Kembali')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(StatusPeminjaman $state) => $state->color())
                    ->formatStateUsing(fn(StatusPeminjaman $state) => $state->label()),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
