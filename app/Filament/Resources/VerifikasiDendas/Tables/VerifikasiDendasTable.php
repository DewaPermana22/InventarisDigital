<?php

namespace App\Filament\Resources\VerifikasiDendas\Tables;

use Filament\Tables\Table;
use App\Enums\StatusPeminjaman;
use App\Enums\OpsiBank;
use App\Enums\HakAkses;
use App\Enums\OpsiEwallet;
use App\Models\VerifikasiPengembalian;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class VerifikasiDendasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Data Verifikasi Denda Kosong')
            ->emptyStateDescription('Tidak terdapat pengembalian barang dengan denda untuk diverifikasi saat ini.')
            ->recordUrl(null)
            ->columns([
                ImageColumn::make('barang.foto')
                    ->label('Foto')
                    ->square()
                    ->defaultImageUrl(url('/images/placeholder.png')),

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
                Action::make('verifikasi')
                    ->label('Verifikasi')
                    ->color('success')
                    ->icon(Heroicon::DocumentCheck)
                    ->visible(fn($record) => $record->status === StatusPeminjaman::MENUNGGU_VERIFIKASI)
                    ->button()
                    ->modalHeading('Verifikasi Pengembalian')
                    ->modalDescription('Periksa data sebelum memverifikasi.')
                    ->modalWidth('2xl')
                    ->modalSubmitAction(fn(Action $action) =>
                    $action
                        ->label('Verifikasi')
                        ->color('success'))
                    ->color('warning')
                    ->modalCancelAction(
                        fn(Action $action) =>
                        $action
                            ->label('Batal')
                            ->color('danger')
                    )


                    ->form(fn($record) => [
                        Grid::make(2)->schema([
                            TextInput::make('metode_pembayaran')
                                ->label('Metode Pembayaran')
                                ->default($record->verifikasiPengembalian?->metode_pembayaran?->label() ?? '-')
                                ->disabled(),

                            TextInput::make('nama_bank')
                                ->label('Nama Bank')
                                ->default(
                                    $record->verifikasiPengembalian?->nama_bank
                                        ? OpsiBank::from($record->verifikasiPengembalian->nama_bank)->label()
                                        : '-'
                                )
                                ->disabled(),
                        ]),

                        Grid::make(2)->schema([
                            TextInput::make('total_bayar')
                                ->label('Total Bayar')
                                ->default($record->verifikasiPengembalian?->total_bayar)
                                ->disabled(),

                            TextInput::make('nama_ewallet')
                                ->label('Nama E-Wallet')
                                ->default(
                                    $record->verifikasiPengembalian?->nama_ewallet
                                        ? OpsiEwallet::from($record->verifikasiPengembalian->nama_ewallet)->label()
                                        : '-'
                                )
                                ->disabled(),
                        ]),

                        FileUpload::make('path_bukti_pembayaran')
                            ->label('Bukti Pembayaran')
                            ->directory('bukti_pembayaran')
                            ->image()
                            ->openable()
                            ->downloadable()
                            ->disabled()
                            ->default(fn($record) => $record->verifikasiPengembalian?->path_bukti_pembayaran),
                    ])

                    ->action(function ($record) {
                        DB::transaction(function () use ($record) {
                            $verifikasi = VerifikasiPengembalian::where('peminjaman_id', $record->id)
                                ->lockForUpdate()
                                ->firstOrFail();

                            $verifikasi->update([
                                'terverifikasi' => true,
                                'updated_by' => Auth::id(),
                            ]);

                            $record->update([
                                'status' => StatusPeminjaman::DIKEMBALIKAN,
                                'updated_by' => Auth::id(),
                            ]);

                            Notification::make()
                                ->title('Berhasil diverifikasi')
                                ->success()
                                ->send();

                            Notification::make()
                                ->title('Pengembalian diverifikasi')
                                ->success()
                                ->body('Pengembalian barang kamu telah diverifikasi.')
                                ->sendToDatabase($record->peminjam);
                        });
                    })

                    ->extraModalFooterActions([
                        Action::make('tolak_verifikasi')
                            ->label('Tolak Verifikasi')
                            ->color('warning')
                            ->modalHeading('Tolak Verifikasi')
                            ->modalSubmitAction(
                                fn(Action $action) =>
                                $action
                                    ->label('Tolak')
                                    ->color('danger')
                            )

                            ->requiresConfirmation()
                            ->color('warning')
                            ->form([
                                Textarea::make('alasan_penolakan')
                                    ->label('Alasan Penolakan')
                                    ->required(),
                            ])
                            ->action(function (array $data, $record) {
                                DB::transaction(function () use ($data, $record) {
                                    $verifikasi = VerifikasiPengembalian::where('peminjaman_id', $record->id)
                                        ->lockForUpdate()
                                        ->firstOrFail();

                                    $verifikasi->update([
                                        'terverifikasi' => false,
                                        'updated_by' => Auth::id(),
                                    ]);

                                    $record->update([
                                        'status' => StatusPeminjaman::VERIFIKASI_DITOLAK,
                                        'updated_by' => Auth::id(),
                                    ]);

                                    Notification::make()
                                        ->title('Verifikasi ditolak')
                                        ->danger()
                                        ->send();

                                    Notification::make()
                                        ->title('Pengembalian ditolak')
                                        ->danger()
                                        ->body('Pengembalian barang ditolak: ' . $data['alasan_penolakan'])
                                        ->sendToDatabase($record->peminjam);
                                });
                            }),
                    ]),

                Action::make('verifikasi_pengembalian')
                    ->label('Verifikasi')
                    ->color('success')
                    ->icon(Heroicon::CheckCircle)
                    ->visible(fn($record) => $record->status === StatusPeminjaman::MENUNGGU_PERSETUJUAN)
                    ->button()
                    ->requiresConfirmation()
                    ->modalHeading('Verifikasi Pengembalian')
                    ->modalDescription('Periksa data sebelum memverifikasi.')
                    ->modalSubmitAction(fn(Action $action) =>
                    $action
                        ->label('Verifikasi')
                        ->color('success'))
                    ->color('warning')
                    ->modalCancelAction(
                        fn(Action $action) =>
                        $action
                            ->label('Batal')
                            ->color('danger')
                    )
                    ->action(function ($record) {
                        DB::transaction(function () use ($record) {
                            $record->update([
                                'status' => StatusPeminjaman::DIKEMBALIKAN,
                                'tanggal_kembali' => today(),
                                'updated_by' => Auth::id()
                            ]);
                        });
                        $superadmins = User::where('role', HakAkses::SUPERADMIN)
                            ->where('is_active', true)
                            ->get();

                        $petugasLogin = Auth::user();

                        Notification::make()
                            ->title('Pengajuan Disetujui')
                            ->body($petugasLogin->name . ' telah menyetujui pengajuan barang')
                            ->success()
                            ->sendToDatabase($superadmins);
                        Notification::make()
                            ->title('Pengembalian Diverifikasi')
                            ->body('Pengembalian barang ' . $record->barang->nama_barang . ' telah diverifikasi.')
                            ->success()
                            ->sendToDatabase($record->peminjam);

                        Notification::make()
                            ->title('Berhasil memverifikasi pengembalian')
                            ->success()
                            ->send();
                    }),
            ])

            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
