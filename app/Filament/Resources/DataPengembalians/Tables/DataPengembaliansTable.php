<?php

namespace App\Filament\Resources\DataPengembalians\Tables;

use App\Enums\StatusPeminjaman;
use App\Enums\OpsiBank;
use App\Enums\MethodePembayaran;
use App\Enums\OpsiEwallet;
use App\Models\VerifikasiPengembalian;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
                    ->visible(fn($record) => $record->status === StatusPeminjaman::MENUNGGU_VERIFIKASI)
                    ->button()
                    ->modalHeading('Verifikasi Pengembalian')
                    ->modalDescription('Periksa data peminjaman sebelum memverifikasi.')

                    ->form(fn($record) => [

                        Grid::make(2)
                            ->schema([
                                Textinput::make('metode_pembayaran')
                                    ->label('Metode Pembayaran')
                                    ->default($record->verifikasiPengembalian?->metode_pembayaran)
                                    ->formatStateUsing(
                                        fn($state) =>
                                        $state ? MethodePembayaran::from($state)->label() : '-'
                                    )
                                    ->disabled(),
                                TextInput::make('nama_bank')
                                    ->label('Nama Bank')
                                    ->default(
                                        $record->verifikasiPengembalian?->nama_bank
                                            ? OpsiBank::from($record->verifikasiPengembalian?->nama_bank)->label()
                                            : '-'
                                    )
                                    ->visible(
                                        fn() =>
                                        $record->verifikasiPengembalian?->metode_pembayaran === MethodePembayaran::TRANSFER->value
                                    )
                                    ->disabled(),

                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('total_bayar')
                                    ->label('Total Bayar')
                                    ->default($record->verifikasiPengembalian?->total_bayar)
                                    ->disabled(),

                                TextInput::make('nama_ewallet')
                                    ->label('Nama E-Wallet')
                                    ->default(
                                        $record->verifikasiPengembalian?->nama_ewallet
                                            ? OpsiEwallet::from($record->verifikasiPengembalian?->nama_ewallet)->label()
                                            : '-'
                                    )
                                    ->visible(fn($get) => $get('metode_pembayaran') === 'ewallet')
                                    ->disabled(),
                            ]),

                        FileUpload::make('path_bukti_pembayaran')
                            ->label('Bukti Pembayaran')
                            ->disk('public')
                            ->directory('bukti_pembayaran')
                            ->image()
                            ->openable()
                            ->downloadable()
                            ->previewable()
                            ->deletable(false)
                            ->disabled()
                            ->default(fn($record) => $record->verifikasiPengembalian?->path_bukti_pembayaran),

                        Textarea::make('catatan')
                            ->label('Catatan Petugas')
                            ->default($record->verifikasiPengembalian?->catatan)
                            ->disabled(),

                    ])

                    ->action(function (array $data, $record) {
                        DB::transaction(function () use ($data, $record) {

                            $verifikasi = VerifikasiPengembalian::where('peminjaman_id', $record->id)
                                ->lockForUpdate()
                                ->firstOrFail();

                            $verifikasi->update([
                                'terverifikasi' => true,
                                'catatan' => $data['catatan'] ?? null,
                                'updated_by' => Auth::id(),
                            ]);

                            $record->update([
                                'status' => StatusPeminjaman::DIKEMBALIKAN,
                                'updated_by' => Auth::id(),
                            ]);
                        });
                    })

                    ->successNotificationTitle('Pengembalian berhasil diverifikasi')
                    ->failureNotificationTitle('Gagal memverifikasi pengembalian')
                    ->requiresConfirmation(),
            ])

            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
