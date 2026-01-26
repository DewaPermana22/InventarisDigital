<?php

namespace App\Filament\Resources\RiwayatPeminjamen\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Schema;
use App\Enums\StatusPeminjaman;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class RiwayatPeminjamanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Peminjaman')
                    ->description("Detail data peminjaman barang")
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('id')
                                    ->label('Kode Peminjaman')
                                    ->icon(Heroicon::Hashtag)
                                    ->copyable()
                                    ->weight('bold'),

                                TextEntry::make('peminjam.name')
                                    ->label('Nama Peminjam')
                                    ->copyable()
                                    ->weight('bold'),

                                TextEntry::make('petugas.name')
                                    ->label('Nama Petugas')
                                    ->copyable()
                                    ->placeholder("-")
                                    ->weight('bold'),

                                TextEntry::make('tanggal_pinjam')
                                    ->label('Tanggal Pinjam')
                                    ->date('d F Y')
                                    ->placeholder("-")
                                    ->icon(Heroicon::Calendar),

                                TextEntry::make('tanggal_disetujui')
                                    ->label('Tanggal Disetujui')
                                    ->date('d F Y')
                                    ->placeholder("-")
                                    ->icon(Heroicon::Calendar),

                                TextEntry::make('tanggal_kembali')
                                    ->label('Tanggal Kembali')
                                    ->date('d F Y')
                                    ->placeholder("-")
                                    ->icon(Heroicon::Calendar),

                                TextEntry::make('tanggal_pengembalian')
                                    ->label('Tanggal Dikembalikan')
                                    ->date('d F Y, H:i')
                                    ->icon(Heroicon::Calendar)
                                    ->placeholder("-")
                                    ->color('success'),

                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn($state): string => match ($state) {
                                        StatusPeminjaman::DIKEMBALIKAN => 'success',
                                        StatusPeminjaman::DIPINJAM => 'primary',
                                        StatusPeminjaman::TERLAMBAT => 'danger',
                                        StatusPeminjaman::DITOLAK => 'danger',
                                        StatusPeminjaman::DIBATALKAN => 'warning',
                                        StatusPeminjaman::BELUM_DISETUJUI => 'warning',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn($state): string => $state instanceof StatusPeminjaman ? strtoupper($state->value) : strtoupper($state)),
                            ]),
                    ])
                    ->columnSpanFull(),

                Section::make('Data Barang')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                ImageEntry::make('barang.foto')
                                    ->label('Foto Barang')
                                    ->defaultImageUrl(url('/images/no-image.png'))
                                    ->columnSpanFull(),

                                TextEntry::make('barang.name')
                                    ->label('Nama Barang')
                                    ->weight('bold'),

                                TextEntry::make('barang.kode_barang')
                                    ->label('Kode Barang')
                                    ->icon(Heroicon::QrCode)
                                    ->copyable(),

                                TextEntry::make('barang.category.name')
                                    ->label('Kategori')
                                    ->badge()
                                    ->color('info'),

                                TextEntry::make('barang.room.name')
                                    ->label('Ruangan'),
                            ]),
                    ])
                    ->columns(1),

                Section::make('Informasi Tambahan')
                    ->schema([
                        TextEntry::make('keperluan')
                            ->label('Keperluan Peminjaman')
                            ->icon(Heroicon::PaperClip)
                            ->columnSpanFull()
                            ->placeholder('Tidak ada keterangan'),

                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label('Diajukan Pada')
                                    ->dateTime('d F Y, H:i')
                                    ->icon(Heroicon::OutlinedClock),

                                TextEntry::make('updated_at')
                                    ->label('Terakhir Diupdate')
                                    ->dateTime('d F Y, H:i')
                                    ->icon(Heroicon::OutlinedClock)
                                    ->since(),
                            ]),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }
}
