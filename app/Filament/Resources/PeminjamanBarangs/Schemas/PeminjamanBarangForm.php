<?php

namespace App\Filament\Resources\PeminjamanBarangs\Schemas;

use App\Enums\KondisiBarang;
use App\Enums\StatusPeminjaman;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;


class PeminjamanBarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Peminjaman')
                    ->description(fn(string $operation) => match ($operation) {
                        'create' => 'Lengkapi data peminjaman barang',
                        'view'   => 'Detail data peminjaman barang',
                        default  => null,
                    })
                    ->components([
                        TextInput::make('barang_id')
                            ->label('Barang')
                            ->formatStateUsing(
                                fn($record) =>
                                $record && $record->barang ?
                                "{$record->barang->name} | {$record->barang->kode_barang}"
                                : '-'
                            )
                            ->disabled()
                            ->visible(fn(string $operation) => $operation === 'view'),
                        Select::make('barang_id')
                            ->label('Barang')
                            ->visible(fn(string $operation) => $operation !== 'view')
                            ->relationship(
                                name: 'barang',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn(Builder $query) =>
                                $query
                                    ->where('kondisi', KondisiBarang::BAIK)
                                    ->whereDoesntHave('peminjaman', function (Builder $query) {
                                        $query->whereNotIn(
                                            'status',
                                            StatusPeminjaman::inactive()
                                        );
                                    })
                                    ->with('category')
                            )
                            ->searchable(['kode_barang', 'id', 'name'])
                            ->preload()
                            ->getOptionLabelFromRecordUsing(
                                fn($record) =>
                                "{$record->kode_barang} / {$record->name}"
                            )
                            ->required(),

                        DatePicker::make('tanggal_pinjam')
                            ->label('Tanggal Pinjam')
                            ->required()
                            ->minDate(now()->startOfDay())
                            ->maxDate(now()->endOfYear()),

                        Textarea::make('keperluan')
                            ->label('Keperluan')
                            ->helperText('opsional, deskripsikan keperluan anda dalam meminjam barang')
                            ->rows(3)
                    ]),
            ]);
    }
}
