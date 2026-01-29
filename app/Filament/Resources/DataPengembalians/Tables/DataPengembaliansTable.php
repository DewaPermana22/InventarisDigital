<?php

namespace App\Filament\Resources\DataPengembalians\Tables;

use App\Enums\StatusPeminjaman;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\VerifikasiPengembalian;
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Storage;

class DataPengembaliansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Data Verifikasi Pengembalian Kosong')
            ->emptyStateDescription('Belum terdapat pengajuan pengembalian yang masuk untuk diverifikasi.')
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
                Action::make('verifikasi')
                    ->label('Verifikasi')
                    ->color('warning')
                    ->icon(Heroicon::DocumentCheck)
                    ->visible(
                        fn($record) =>
                        $record->status === StatusPeminjaman::MENUNGGU_VERIFIKASI
                    )
                    ->button()
                    ->modalHeading('Verifikasi Pengembalian')
                    ->modalDescription('Periksa data peminjaman sebelum memverifikasi.')
                    ->form(fn($record) => [
                        TextInput::make('total_bayar')
                            ->label('Total Bayar')
                            ->numeric()
                            ->required()
                            ->default($record->verifikasiPengembalian?->total_bayar),

                        TextInput::make('nama_bank')
                            ->label('Nama Bank')
                            ->default($record->verifikasiPengembalian?->nama_bank),

                        TextInput::make('nama_ewallet')
                            ->label('Nama E-Wallet')
                            ->default($record->verifikasiPengembalian?->nama_ewallet),

                        FileUpload::make('path_bukti_pembayaran')
                            ->label('Bukti Pembayaran')
                            ->disk('public')
                            ->directory('bukti_pembayaran')
                            ->image()
                            ->openable()
                            ->downloadable()
                            ->previewable()
                            ->default(fn($record) => $record->verifikasiPengembalian?->path_bukti_pembayaran),

                        Textarea::make('catatan')
                            ->label('Catatan Petugas')
                            ->default($record->verifikasiPengembalian?->catatan),

                        Toggle::make('terverifikasi')
                            ->label('Terverifikasi')
                            ->default(true)
                            ->required(),
                    ])

                    ->action(function (array $data, $record) {

                        DB::transaction(function () use ($data, $record) {

                            $verifikasi = VerifikasiPengembalian::where('peminjaman_id', $record->id)
                                ->lockForUpdate()
                                ->firstOrFail();

                            // update verifikasi
                            $verifikasi->update([
                                'terverifikasi' => true,
                                'catatan' => $data['catatan'] ?? null,
                                'updated_by' => Auth::id(),
                            ]);

                            // update peminjaman
                            $record->update([
                                'status' => StatusPeminjaman::DIKEMBALIKAN,
                                'updated_by' => Auth::id(),
                            ]);
                        });
                    })
                    ->successNotificationTitle('Pengembalian berhasil diverifikasi')
                    ->failureNotificationTitle('Gagal memverifikasi pengembalian')
                    ->requiresConfirmation()
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
