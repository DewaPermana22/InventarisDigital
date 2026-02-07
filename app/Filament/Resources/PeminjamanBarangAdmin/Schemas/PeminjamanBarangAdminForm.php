<?php

namespace App\Filament\Resources\PeminjamanBarangAdmin\Schemas;

use App\Enums\KondisiBarang;
use App\Enums\StatusPeminjaman;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;

class PeminjamanBarangAdminForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Peminjaman')
                    ->description('Lengkapi data peminjaman barang')
                    ->schema([
                        Select::make('peminjam_id')
                            ->label('Peminjam')
                            ->relationship('peminjam', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

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

                        Textarea::make('keperluan')
                            ->label('Keperluan')
                            ->rows(4)
                            ->placeholder('Contoh: Untuk kegiatan praktikum jaringan')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(1),
            ]);
    }
}
