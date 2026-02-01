<?php

namespace App\Filament\Resources\RiwayatDendas\Tables;

use App\Enums\MethodePembayaran;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
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
                    ->formatStateUsing(fn($state) => $state?->label() ?? '-'),


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
                    ->modalWidth('2xl')
                    ->requiresConfirmation()
                    ->modalHeading('Detail Pengembalian & Denda')
                    ->modalDescription('Berikut adalah detail pengembalian barang dan pembayaran denda.')
                    ->modalCancelAction(
                        fn(Action $action) =>
                        $action
                            ->label('Tutup')
                            ->color('danger')
                    )
                    ->infolist(fn($record) => [
                        Grid::make(2)->schema([
                            TextEntry::make('kode_barang')
                                ->label('Kode Barang')
                                ->state($record->barang?->kode_barang),

                            TextEntry::make('nama_barang')
                                ->label('Nama Barang')
                                ->state($record->barang?->name),
                        ]),

                        Grid::make(2)->schema([
                            TextEntry::make('tanggal_kembali')
                                ->label('Tanggal Kembali')
                                ->state($record->tanggal_kembali?->format('d/m/Y')),

                            TextEntry::make('total_denda')
                                ->label('Total Denda')
                                ->money('IDR')
                                ->state($record->verifikasiPengembalian?->total_bayar),
                        ]),

                        Grid::make(2)->schema([
                            TextEntry::make('metode_pembayaran')
                                ->label('Metode Pembayaran')
                                ->state($record->verifikasiPengembalian?->metode_pembayaran?->label()),

                            TextEntry::make('status_verifikasi')
                                ->label('Status')
                                ->badge()
                                ->color(
                                    fn() =>
                                    $record->verifikasiPengembalian?->terverifikasi
                                        ? 'success'
                                        : 'warning'
                                )
                                ->state(
                                    $record->verifikasiPengembalian?->terverifikasi
                                        ? 'Terverifikasi'
                                        : 'Belum Terverifikasi'
                                ),
                        ]),

                        ImageEntry::make('bukti_pembayaran')
                            ->label('Bukti Pembayaran')
                            ->state($record->verifikasiPengembalian?->path_bukti_pembayaran)
                            ->disk('public')
                            ->url(fn($state) => $state ? Storage::url($state) : null)
                            ->openUrlInNewTab(),
                    ])
            ])->striped();
    }
}
