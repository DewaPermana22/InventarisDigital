<?php

namespace App\Filament\Resources\PeminjamanBarangs\Tables;

use App\Enums\StatusPeminjaman;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use App\Enums\MethodePembayaran;
use App\Enums\OpsiBank;
use App\Enums\OpsiEwallet;
use App\Models\User;
use App\Models\VerifikasiPengembalian;
use Illuminate\Support\Facades\Auth;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Carbon;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Enums\HakAkses;
use Filament\Tables\Filters\SelectFilter;

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
                SelectFilter::make('status')
                    ->label('Status Peminjaman')
                    ->options(
                        collect(StatusPeminjaman::active())
                            ->mapWithKeys(fn($case) => [
                                $case->value => $case->label()
                            ])
                            ->toArray()
                    )
                    ->native(false)
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

                        $petugas = User::where('role', HakAkses::ADMIN)->where('is_active', true)->get();
                        // notifikasi ke peminjam
                        Notification::make()
                            ->title('Pengajuan Berhasil Dibatalkan')
                            ->body('Pengajuan peminjaman barang Anda telah dibatalkan.')
                            ->success()
                            ->sendToDatabase($record->peminjam);

                        //Pop Up
                        Notification::make()
                            ->title('Pengajuan Berhasil Dibatalkan')
                            ->body('Pengajuan peminjaman barang Anda telah dibatalkan.')
                            ->success()
                            ->send();

                        // notifikasi ke petugas
                        Notification::make()
                            ->title('Peminjaman Dibatalkan')
                            ->danger()
                            ->body('Peminjaman ' . $record->barang->name . ' oleh ' . $record->peminjam->name . ' telah dibatalkan.')
                            ->sendToDatabase($petugas);
                    }),

                // Kembalikan Barang (Terlambat)
                Action::make('kembalikan_terlambat')
                    ->label('Kembalikan')
                    ->button()
                    ->color(Color::Red)
                    ->icon(Heroicon::Clock)
                    ->visible(fn($record) => $record->status === StatusPeminjaman::TERLAMBAT)
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Pengembalian & Pembayaran')
                    ->modalDescription(function ($record) {
                        $hariTerlambat = Carbon::parse($record->tanggal_kembali)
                            ->startOfDay()
                            ->diffInDays(now()->startOfDay());

                        $denda = $hariTerlambat * 5000;

                        return new HtmlString(
                            "Anda terlambat <strong>{$hariTerlambat} hari</strong>.<br> Total denda: <strong>Rp " . number_format($denda, 0, ',', '.') . "</strong>"
                        );
                    })

                    ->form([
                        Select::make('metode_pembayaran')
                            ->label('Metode Pembayaran')
                            ->options(MethodePembayaran::class)
                            ->required()
                            ->reactive(),

                        FileUpload::make('path_bukti_pembayaran')
                            ->label('Bukti Pembayaran')
                            ->image()
                            ->directory('bukti_pembayaran')
                            ->required()
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->imagePreviewHeight('200'),

                        Select::make('jenis_ewallet')
                            ->label('Pilih E-Wallet')
                            ->options(OpsiEwallet::options())
                            ->visible(fn(Get $get) => $get('metode_pembayaran') === MethodePembayaran::EWALLET)
                            ->required(fn(Get $get) => $get('metode_pembayaran') === MethodePembayaran::EWALLET)
                            ->reactive(),

                        Select::make('bank_tujuan')
                            ->label('Pilih Bank')
                            ->options(OpsiBank::options())
                            ->visible(fn(Get $get) => $get('metode_pembayaran') === MethodePembayaran::TRANSFER)
                            ->required(fn(Get $get) => $get('metode_pembayaran') === MethodePembayaran::TRANSFER)
                            ->reactive(),

                        TextInput::make('keterangan')
                            ->label('Catatan (opsional)')
                            ->placeholder('Contoh: bayar via QRIS BCA'),
                    ])
                    ->modalSubmitActionLabel('Kembalikan & Bayar')
                    ->action(function ($record, array $data) {
                        DB::beginTransaction();

                        try {
                            $hariTerlambat = Carbon::parse($record->tanggal_kembali)
                                ->startOfDay()
                                ->diffInDays(now()->startOfDay());

                            $totalBayar = $hariTerlambat * 5000;

                            $record->update([
                                'status' => StatusPeminjaman::MENUNGGU_VERIFIKASI,
                                'updated_by' => $record->peminjam_id,
                            ]);

                            VerifikasiPengembalian::create([
                                'peminjaman_id'          => $record->id,
                                'terverifikasi'          => false,
                                'metode_pembayaran'     => $data['metode_pembayaran'],
                                'path_bukti_pembayaran' => $data['path_bukti_pembayaran'],
                                'nama_bank'             => $data['bank_tujuan'] ?? null,
                                'nama_ewallet'          => $data['jenis_ewallet'] ?? null,
                                'total_bayar'           => $totalBayar,
                                'catatan'               => $data['keterangan'] ?? null,
                                'created_by'            => Auth::id()
                            ]);

                            DB::commit();

                            Notification::make()
                                ->title('Pengembalian berhasil dikirim')
                                ->body('Menunggu verifikasi petugas.')
                                ->success()
                                ->send();

                            Notification::make()
                                ->title('Pengembalian berhasil dikirim')
                                ->body('Menunggu verifikasi petugas.')
                                ->success()
                                ->icon(Lucideicon::Clock)
                                ->sendToDatabase(Auth::user());

                            if ($record->petugas_id) {
                                $petugas = User::find($record->petugas_id);
                                if ($petugas) {
                                    Notification::make()
                                        ->title('Pengembalian menunggu verifikasi')
                                        ->body('Ada pengembalian dengan denda yang perlu diverifikasi.')
                                        ->icon(Lucideicon::Clock)
                                        ->sendToDatabase($petugas);
                                }
                            }

                            return redirect()->route('filament.dashboard.resources.riwayat-dendas.index');
                        } catch (\Throwable $e) {
                            DB::rollBack();

                            report($e);

                            Notification::make()
                                ->title('Gagal mengirim pengembalian')
                                ->body('Terjadi kesalahan, silakan coba lagi.')
                                ->danger()
                                ->send();
                        }
                    }),

                // Verifikasi Ulang
                Action::make('verifikasi_ulang')
                    ->label('Verifikasi Ulang')
                    ->button()
                    ->color(Color::Red)
                    ->icon(Heroicon::ExclamationCircle)
                    ->visible(fn($record) => $record->status === StatusPeminjaman::VERIFIKASI_DITOLAK)
                    ->requiresConfirmation()
                    ->modalHeading('Kirim Ulang Bukti Pengembalian & Pembayaran')
                    ->modalDescription(function ($record) {
                        $hariTerlambat = Carbon::parse($record->tanggal_kembali)
                            ->startOfDay()
                            ->diffInDays(now()->startOfDay());

                        $denda = $hariTerlambat * 5000;

                        return new HtmlString(
                            "Anda terlambat <strong>{$hariTerlambat} hari</strong>.<br> Total denda: <strong>Rp " . number_format($denda, 0, ',', '.') . "</strong>"
                        );
                    })

                    ->form([
                        Select::make('metode_pembayaran')
                            ->label('Metode Pembayaran')
                            ->options(MethodePembayaran::class)
                            ->required()
                            ->reactive(),

                        FileUpload::make('path_bukti_pembayaran')
                            ->label('Bukti Pembayaran')
                            ->image()
                            ->directory('bukti_pembayaran')
                            ->required()
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->imagePreviewHeight('200'),

                        Select::make('jenis_ewallet')
                            ->label('Pilih E-Wallet')
                            ->options(OpsiEwallet::options())
                            ->visible(fn(Get $get) => $get('metode_pembayaran') === MethodePembayaran::EWALLET)
                            ->required(fn(Get $get) => $get('metode_pembayaran') === MethodePembayaran::EWALLET)
                            ->reactive(),

                        Select::make('bank_tujuan')
                            ->label('Pilih Bank')
                            ->options(OpsiBank::options())
                            ->visible(fn(Get $get) => $get('metode_pembayaran') === MethodePembayaran::TRANSFER)
                            ->required(fn(Get $get) => $get('metode_pembayaran') === MethodePembayaran::TRANSFER)
                            ->reactive(),

                        TextInput::make('keterangan')
                            ->label('Catatan (opsional)')
                            ->placeholder('Contoh: bayar via QRIS BCA'),
                    ])
                    ->modalSubmitActionLabel('Kirim Ulang')
                    ->action(function ($record, array $data) {
                        DB::beginTransaction();

                        try {
                            $hariTerlambat = Carbon::parse($record->tanggal_kembali)
                                ->startOfDay()
                                ->diffInDays(now()->startOfDay());

                            $totalBayar = $hariTerlambat * 5000;

                            $verifikasi = VerifikasiPengembalian::where('peminjaman_id', $record->id)
                                ->latest()
                                ->first();

                            if (! $verifikasi) {
                                throw new \Exception('Data verifikasi sebelumnya tidak ditemukan.');
                            }

                            $record->update([
                                'status' => StatusPeminjaman::MENUNGGU_VERIFIKASI,
                                'updated_by' => $record->peminjam_id,
                            ]);

                            $verifikasi->update([
                                'terverifikasi'          => false,
                                'metode_pembayaran'     => $data['metode_pembayaran'],
                                'path_bukti_pembayaran' => $data['path_bukti_pembayaran'],
                                'nama_bank'             => $data['bank_tujuan'] ?? null,
                                'nama_ewallet'          => $data['jenis_ewallet'] ?? null,
                                'total_bayar'           => $totalBayar,
                                'catatan'               => $data['keterangan'] ?? null,
                                'updated_by'            => Auth::id(),
                            ]);

                            DB::commit();

                            Notification::make()
                                ->title('Pengembalian berhasil dikirim')
                                ->body('Menunggu verifikasi petugas.')
                                ->success()
                                ->send();

                            Notification::make()
                                ->title('Pengembalian berhasil dikirim')
                                ->body('Menunggu verifikasi petugas.')
                                ->success()
                                ->icon(Lucideicon::Clock)
                                ->sendToDatabase(Auth::user());

                            if ($record->petugas_id) {
                                $petugas = User::find($record->petugas_id);
                                if ($petugas) {
                                    Notification::make()
                                        ->title('Pengembalian menunggu verifikasi')
                                        ->warning()
                                        ->body('Ada pengembalian dengan denda yang perlu diverifikasi.')
                                        ->icon(Lucideicon::Clock)
                                        ->sendToDatabase($petugas);
                                }
                            }

                            return redirect()->route('filament.dashboard.resources.riwayat-dendas.index');
                        } catch (\Throwable $e) {
                            DB::rollBack();

                            report($e);

                            Notification::make()
                                ->title('Gagal mengirim pengembalian')
                                ->body('Terjadi kesalahan, silakan coba lagi.')
                                ->danger()
                                ->send();
                        }
                    })
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }
}
