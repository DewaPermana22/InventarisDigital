<?php

namespace App\Filament\Resources\DataPengembalians\Tables;

use App\Enums\StatusPeminjaman;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
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
            ->recordActions([
                Action::make('setujui_pengembalian')
                    ->label('Terima')
                    ->button()
                    ->icon(Heroicon::CheckCircle)
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Pengembalian?')
                    ->modalDescription('Apakah Anda yakin ingin menyetujui pengembalian barang ini?')
                    ->modalSubmitActionLabel('Ya, Setujui')
                    ->action(function ($record) {
                        $record->update([
                            'status' => StatusPeminjaman::DIKEMBALIKAN,
                            'updated_at' => now(),
                        ]);

                        // Notifikasi ke peminjam (database)
                        Notification::make()
                            ->title('Pengembalian Disetujui')
                            ->body('Pengembalian barang "' . $record->barang->name . '" telah disetujui oleh petugas.')
                            ->success()
                            ->sendToDatabase($record->peminjam);

                        // Toast ke petugas/admin
                        Notification::make()
                            ->title('Pengembalian Disetujui')
                            ->body('Barang "' . $record->barang->name . '" berhasil dikembalikan.')
                            ->success()
                            ->send();
                    })
                    ->visible(
                        fn($record) =>
                        $record->status === StatusPeminjaman::PROSES_PENGEMBALIAN
                    ),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
