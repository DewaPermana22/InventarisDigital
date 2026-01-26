<?php

namespace App\Filament\Resources\PeminjamanBarangs\Tables;

use App\Enums\StatusPeminjaman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;

class PeminjamanBarangsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Belum ada peminjaman barang')
            ->emptyStateDescription('Silahkan ajukan peminjaman barang yang tersedia')

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
                    ->formatStateUsing(fn($state) => Str::limit($state, 20))
                    ->tooltip(fn($state) => $state)
                    ->weight('bold'),

                TextColumn::make('barang.name')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => Str::limit($state, 20))
                    ->tooltip(fn($state) => $state)
                    ->weight('bold'),

                TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(StatusPeminjaman $state) => $state->color())
                    ->formatStateUsing(fn(StatusPeminjaman $state) => $state->label())
                    ->searchable(),
            ])

            ->filters([
                TrashedFilter::make(),
            ])

            ->recordActions([
                // Batalkan (Belum Di setujui)
                Action::make('batalkan')
                    ->label('Batalkan')
                    ->color('danger')
                    ->icon(Heroicon::XCircle)
                    ->visible(
                        fn($record) =>
                        $record->status === StatusPeminjaman::BELUM_DISETUJUI
                    )
                    ->button()
                    ->requiresConfirmation()
                    ->modalHeading('Batalkan Pengajuan?')
                    ->modalDescription("Anda yakin ingin membatalkan pengajuan?")
                    ->modalIcon(Heroicon::OutlinedXCircle)
                    ->modalSubmitActionLabel('Ya, Batalkan')
                    ->action(function ($record) {
                        $record->update([
                            'status' => StatusPeminjaman::DIBATALKAN,
                            'updated_at' => now()
                        ]);
                    }),

                // Kembalikan Barang
                // Action::make('kembalikan')
                // ->label('Kembalikan')
                // ->color('success')
                // ->icon(Heroicon::Pencil)
                // ->visible(
                //     fn($record) =>
                //     $record->status === StatusPeminjaman::DIPINJAM
                // )
                // ->button()
                // ->requiresConfirmation()
                // ->modalHeading('Kembalikan Barang?')
                // ->modalDescription("Anda yakin ingin mengembalikan barang yang anda pinjam?")
                // ->modalIcon(Heroicon::OutlinedCheckBadge)
                // ->modalSubmitActionLabel('Ya, Kembalikan')
                // ->action(function ($record) {
                //     $record->update([
                //         'status' => StatusPeminjaman::DIKEMBALIKAN,
                //         'updated_at' => now()
                //     ]);
                // }),

                // Kembalikan (Sudah Dipinjam)
                Action::make('scan_barcode')
                    ->label('Kembalikan')
                    ->icon(Heroicon::Camera)
                    ->color('success')
                    ->button()
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->status === StatusPeminjaman::DIPINJAM)
                    ->modalHeading('Scan Barcode Barang')
                    ->modalDescription('Arahkan kamera ke barcode barang')
                    ->mountUsing(fn($livewire) => $livewire->barcode = null)
                    ->modalContent(view('scanner.barcode'))
                    ->closeModalByClickingAway(false)

                    // Reset state setiap modal dibuka
                    ->mountUsing(function ($livewire) {
                        $livewire->barcode = null;
                    })

                    ->action(function ($record, $livewire) {
                        $barcode = $livewire->barcode;
                        if (blank($barcode)) {
                            Notification::make()
                                ->title('Barcode belum di-scan')
                                ->warning()
                                ->send();
                            return;
                        }

                        if ($barcode !== $record->barang->kode_barang) {
                            Notification::make()
                                ->title('Barcode tidak sesuai')
                                ->body("Barcode terbaca: {$barcode}")
                                ->danger()
                                ->send();
                            return;
                        }

                        $record->update([
                            'status' => StatusPeminjaman::DIKEMBALIKAN,
                            'tanggal_dikembalikan' => now(),
                        ]);

                        Notification::make()
                            ->title('Barang berhasil dikembalikan')
                            ->body('Silakan cek detail peminjaman')
                            ->success()
                            ->sendToDatabase(Auth::user());

                        // Toast (popup)
                        Notification::make()
                            ->title('Barang berhasil dikembalikan')
                            ->success()
                            ->send();

                        $livewire->dispatch('close-modal');
                    }),


                /* =========================
                 * KEMBALIKAN (TERLAMBAT)
                 * ========================= */
                Action::make('kembalikan_terlambat')
                    ->label('Kembalikan')
                    ->button()
                    ->requiresConfirmation()
                    ->color(Color::Red)
                    ->icon(Heroicon::Clock)
                    ->visible(
                        fn($record) =>
                        $record->status === StatusPeminjaman::TERLAMBAT
                    )
                    ->modalHeading('Konfirmasi Pengembalian')
                    ->modalDescription(function ($record) {
                        $hariTerlambat = Carbon::parse($record->tanggal_kembali)
                            ->startOfDay()
                            ->diffInDays(now()->startOfDay());

                        $denda = $hariTerlambat * 5000;

                        return new HtmlString(
                            "Anda telah terlambat mengembalikan barang selama
                            <strong>{$hariTerlambat} hari</strong>.
                            Pengembalian Anda dikenakan denda sebesar
                            <strong>Rp " . number_format($denda, 0, ',', '.') . "</strong>.
                            Silakan kembalikan barang dan bayar denda Anda."
                        );
                    })
                    ->modalSubmitActionLabel('Kembalikan & Bayar')
                    ->action(function ($record) {
                        $hariTerlambat = Carbon::parse($record->tanggal_kembali)
                            ->startOfDay()
                            ->diffInDays(now()->startOfDay());

                        $record->update([
                            'status' => StatusPeminjaman::DIKEMBALIKAN,
                            'total_denda' => $hariTerlambat * 5000,
                            'tanggal_dikembalikan' => now(),
                        ]);

                        return redirect()->route(
                            'filament.dashboard.resources.riwayat-dendas.index'
                        );
                    }),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])

            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
