<?php

namespace App\Filament\Resources\DataPengembalians\Pages;

use App\Enums\StatusPeminjaman;
use App\Filament\Resources\DataPengembalians\DataPengembalianResource;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use App\Models\PeminjamanBarang;
use App\Models\User;
use App\Enums\HakAkses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ListDataPengembalians extends ListRecords
{
    protected static string $resource = DataPengembalianResource::class;

    protected $listeners = [
        'barcodeScannedRealtime' => 'barcodeScannedRealtime'
    ];

    public function barcodeScannedRealtime($barcode)
    {
        $peminjaman = PeminjamanBarang::whereHas('barang', function ($q) use ($barcode) {
            $q->where('kode_barang', $barcode);
        })
            ->where('status', StatusPeminjaman::DIPINJAM)
            ->first();

        if (!$peminjaman) {
            $this->dispatch('scan-error', message: 'Barang tidak valid atau tidak sedang dipinjam');

            Notification::make()
                ->title('Barang tidak valid atau tidak sedang dipinjam')
                ->danger()
                ->send();

            return;
        }

        try {
            DB::transaction(function () use ($peminjaman) {
                $peminjaman->update([
                    'status' => StatusPeminjaman::DIKEMBALIKAN,
                    'updated_by' => Auth::id(),
                ]);

                Notification::make()
                    ->title('Barang berhasil dikembalikan')
                    ->success()
                    ->send();

                Notification::make()
                    ->title('Pengembalian berhasil')
                    ->body("Barang {$peminjaman->barang->name} berhasil dikembalikan.")
                    ->success()
                    ->sendToDatabase(Auth::user());

                $superadmins = User::where('role', HakAkses::SUPERADMIN)->get();
                Notification::make()
                    ->title('Pengembalian Barang')
                    ->body("Barang {$peminjaman->barang->name} telah dikembalikan.")
                    ->success()
                    ->sendToDatabase($superadmins);

                $peminjam = $peminjaman->peminjam;
                Notification::make()
                    ->title('Barang berhasil dikembalikan')
                    ->body("Barang {$peminjaman->barang->name} telah dikembalikan.")
                    ->success()
                    ->sendToDatabase($peminjam);

                if (now()->gt($peminjaman->tanggal_kembali)) {
                    $hariTelat = now()->diffInDays($peminjaman->tanggal_kembali);

                    $peminjaman->update([
                        'status' => StatusPeminjaman::TERLAMBAT,
                        'updated_by' => Auth::id(),
                    ]);

                    Notification::make()
                        ->title('Pengembalian Terlambat')
                        ->body("Pengembalian barang yang anda pinjam dikenakan denda, anda telat selama {$hariTelat} hari.")
                        ->danger()
                        ->sendToDatabase($peminjam);

                    Notification::make()
                        ->title('Pengembalian terlambat')
                        ->body("Terlambat {$hariTelat} hari.")
                        ->warning()
                        ->send();

                    Notification::make()
                        ->title('Peminjam terlambat')
                        ->body("Peminjam telat {$hariTelat} hari.")
                        ->warning()
                        ->sendToDatabase(Auth::user());
                }
            });

            $this->dispatch('scan-processed', barcode: $barcode);
        } catch (\Exception $e) {
            Log::error('Error saat memproses pengembalian', [
                'barcode' => $barcode,
                'error' => $e->getMessage()
            ]);

            $this->dispatch('scan-error', message: 'Terjadi kesalahan saat memproses pengembalian');

            Notification::make()
                ->title('Terjadi kesalahan')
                ->body('Gagal memproses pengembalian barang.')
                ->danger()
                ->send();
        }
    }

    public function getTitle(): string|Htmlable
    {
        return "Data Pengembalian";
    }

    public function getSubheading(): string|Htmlable|null
    {
        return "Riwayat peminjaman barang yang telah selesai";
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('kembalikan_peminjaman')
                ->icon(Heroicon::Camera)
                ->label('Pengembalian')
                ->color('success')
                ->modalHeading('Scan Barcode Barang')
                ->modalDescription('Arahkan kamera ke barcode barang untuk pengembalian')
                ->modalContent(view('scanner.barcode'))
                ->closeModalByClickingAway(false)
                ->modalSubmitAction(false)
                ->modalCancelAction(false)
                ->modalWidth('md')
                ->mountUsing(function () {
                    $this->dispatch('init-barcode-scanner');
                })
                ->action(function () {}),

            Action::make('export-laporan')
                ->label("Export Laporan")
                ->color('primary')
                ->icon(Heroicon::OutlinedPrinter)
                ->requiresConfirmation()
                ->modalHeading('Export Laporan Peminjaman')
                ->modalIcon(Heroicon::Printer)
                ->modalDescription('Pilih periode laporan yang ingin diexport')
                ->form([
                    Select::make('filter_type')
                        ->label('Tipe Filter')
                        ->options([
                            'tahun' => 'Per Tahun',
                            'bulan' => 'Per Bulan',
                        ])
                        ->default('tahun')
                        ->live()
                        ->native(false)
                        ->required(),

                    Select::make('bulan')
                        ->label('Pilih Bulan')
                        ->options(function () {
                            $bulanSekarang = now()->month;
                            $options = [];

                            for ($i = 1; $i <= $bulanSekarang; $i++) {
                                $options[$i] = Carbon::create(null, $i)->locale('id')->translatedFormat('F');
                            }

                            return $options;
                        })
                        ->default(now()->month)
                        ->native(false)
                        ->required()
                        ->visible(fn(Get $get) => $get('filter_type') === 'bulan'),

                    TextInput::make('tahun')
                        ->label('Tahun')
                        ->default(now()->year)
                        ->readOnly()
                        ->disabled(),
                ])
                ->modalSubmitActionLabel('Ya, Export')
                ->action(function (array $data) {
                    $filterType = $data['filter_type'];
                    $bulan = $data['bulan'] ?? null;
                    $tahun = now()->year;

                    Notification::make()
                        ->success()
                        ->title('Export Berhasil')
                        ->body('File laporan peminjaman sedang diunduh.')
                        ->duration(3000)
                        ->send();

                    $periodeText = $filterType === 'bulan' && $bulan
                        ? Carbon::create($tahun, $bulan)->locale('id')->translatedFormat('F Y')
                        : "Tahun {$tahun}";

                    Notification::make()
                        ->success()
                        ->title('Laporan Peminjaman berhasil di export')
                        ->body("Anda telah mengexport Laporan Peminjaman ({$periodeText}) pada " . now()->format('d-m-Y H:i'))
                        ->icon('heroicon-o-document-text')
                        ->actions([
                            Action::make('view')
                                ->button()
                                ->label('Download Lagi')
                                ->url(route('export.laporan-peminjaman', [
                                    'filter_type' => $filterType,
                                    'bulan' => $bulan,
                                    'tahun' => $tahun
                                ]))
                                ->openUrlInNewTab(),
                        ])
                        ->sendToDatabase(Auth::user());

                    return redirect()->route('export.laporan-peminjaman', [
                        'filter_type' => $filterType,
                        'bulan' => $bulan,
                        'tahun' => $tahun
                    ]);
                })
        ];
    }
}
