<?php

namespace App\Filament\Resources\PengajuanPeminjamen\Tables;

use App\Enums\StatusPeminjaman;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PengajuanPeminjamenTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Belum ada pengajuan peminjaman')
            ->emptyStateDescription('Saat ini belum terdapat pengajuan peminjaman yang perlu diproses')

            ->columns([
                ImageColumn::make('barang.foto')
                    ->label('Foto')
                    ->square()
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->extraImgAttributes([
                        'alt' => 'Foto Barang',
                        'loading' => 'lazy',
                    ]),

                TextColumn::make('barang.kode_barang')
                    ->label('Kode Barang')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Kode barang disalin!')
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('barang.name')
                    ->label('Nama Barang')
                    ->searchable()
                    ->formatStateUsing(fn($state) => Str::limit($state, 20))
                    ->tooltip(fn($state) => $state)
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('peminjam.name')
                    ->label('Peminjam')
                    ->formatStateUsing(fn($state) => Str::limit($state, 20))
                    ->tooltip(fn($state) => $state)
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                Action::make('terima')
                    ->label('Terima')
                    ->color('success')
                    ->icon(Heroicon::CheckCircle)
                    ->visible(
                        fn($record) =>
                        $record->status === StatusPeminjaman::BELUM_DISETUJUI
                    )
                    ->button()
                    ->requiresConfirmation()
                    ->modalHeading('Terima Pengajuan?')
                    ->modalDescription('Anda yakin ingin menyetujui pengajuan peminjaman ini?')
                    ->modalIcon(Heroicon::OutlinedCheckBadge)
                    ->modalSubmitActionLabel('Terima Pengajuan')
                    ->action(function ($record) {
                        $now = now();

                        $record->update([
                            'status'            => StatusPeminjaman::DIPINJAM,
                            'petugas_id'        => Auth::id(),
                            'updated_by'        => Auth::id(),
                            'tanggal_disetujui' => $now,
                            'tanggal_kembali'   => $now->copy()->addDays(7),
                        ]);

                        // NOTIFIKASI KE PEMINJAM
                        Notification::make()
                            ->title('Pengajuan Disetujui')
                            ->body("Pengajuan peminjaman barang {$record->barang->name} telah disetujui.")
                            ->success()
                            ->sendToDatabase($record->peminjam);

                        // TOAST KE PETUGAS
                        Notification::make()
                            ->title('Pengajuan berhasil disetujui')
                            ->success()
                            ->send();
                    }),

                Action::make('tolak')
                    ->label('Tolak')
                    ->color('danger')
                    ->icon(Heroicon::XCircle)
                    ->visible(
                        fn($record) =>
                        $record->status === StatusPeminjaman::BELUM_DISETUJUI
                    )
                    ->button()
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Pengajuan?')
                    ->modalDescription('Anda yakin ingin menolak pengajuan peminjaman ini?')
                    ->modalIcon(Heroicon::OutlinedXCircle)
                    ->modalSubmitActionLabel('Ya, Tolak')
                    ->action(function ($record) {
                        $record->update([
                            'status'     => StatusPeminjaman::DITOLAK,
                            'updated_by' => Auth::id(),
                        ]);

                        // NOTIFIKASI KE PEMINJAM
                        Notification::make()
                            ->title('Pengajuan Ditolak')
                            ->body("Pengajuan peminjaman barang {$record->barang->name} ditolak oleh petugas.")
                            ->danger()
                            ->sendToDatabase($record->peminjam);

                        // TOAST KE PETUGAS
                        Notification::make()
                            ->title('Pengajuan berhasil ditolak')
                            ->danger()
                            ->send();
                    }),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
