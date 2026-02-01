<?php

namespace App\Filament\Resources\RiwayatDendas\Tables;

use App\Enums\MethodePembayaran;
use Filament\Actions\ViewAction;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class RiwayatDendasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(null)
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

                TextColumn::make('tanggal_kembali')
                    ->label('Tanggal Kembali')
                    ->date('d/m/Y'),

                TextColumn::make('verifikasiPengembalian.total_bayar')
                    ->label('Total Denda')
                    ->money('IDR'),

                TextColumn::make('verifikasiPengembalian.metode_pembayaran')
                    ->label('Metode Pembayaran')
                    ->formatStateUsing(
                        fn($state) =>
                        $state ? MethodePembayaran::from($state)->label() : '-'
                    ),

                TextColumn::make('verifikasiPengembalian.terverifikasi')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state ? 'Terverifikasi' : 'Belum')
                    ->color(fn($state) => $state ? 'success' : 'warning'),

                TextColumn::make('verifikasiPengembalian.created_at')
                    ->label('Tanggal Denda')
                    ->date('d/m/Y'),
            ])
            ->recordActions([
                ViewAction::make('detail')
                    ->label('Detail')
                    ->color('primary')
                    ->modalHeading('Detail Pengembalian & Denda')
                    ->modalDescription('Berikut adalah detail pengembalian barang dan pembayaran denda.')
                    ->requiresConfirmation()
                    ->form(fn($record) => [

                        Grid::make(2)->schema([
                            TextInput::make('kode_barang')
                                ->label('Kode Barang')
                                ->default($record->barang?->kode_barang)
                                ->disabled(),

                            TextInput::make('nama_barang')
                                ->label('Nama Barang')
                                ->default($record->barang?->name)
                                ->disabled(),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('tanggal_kembali')
                                ->label('Tanggal Kembali')
                                ->default($record->tanggal_kembali?->format('d/m/Y'))
                                ->disabled(),

                            TextInput::make('total_denda')
                                ->label('Total Denda')
                                ->default($record->verifikasiPengembalian?->total_bayar)
                                ->disabled(),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('metode_pembayaran')
                                ->label('Metode Pembayaran')
                                ->default(
                                    $record->verifikasiPengembalian?->metode_pembayaran
                                        ? \App\Enums\MethodePembayaran::from(
                                            $record->verifikasiPengembalian?->metode_pembayaran
                                        )->label()
                                        : '-'
                                )
                                ->disabled(),

                            TextInput::make('status_verifikasi')
                                ->label('Status')
                                ->default(
                                    $record->verifikasiPengembalian?->terverifikasi
                                        ? 'Terverifikasi'
                                        : 'Belum Terverifikasi'
                                )
                                ->disabled(),
                        ]),

                        FileUpload::make('bukti_pembayaran')
                            ->label('Bukti Pembayaran')
                            ->disk('public')
                            ->directory('bukti_pembayaran')
                            ->image()
                            ->openable()
                            ->downloadable()
                            ->previewable()
                            ->deletable(false)
                            ->disabled()
                            ->default($record->verifikasiPengembalian?->path_bukti_pembayaran),

                        Textarea::make('catatan')
                            ->label('Catatan Petugas')
                            ->default($record->verifikasiPengembalian?->catatan)
                            ->disabled(),
                    ])
            ]);
    }
}
