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
use Illuminate\Support\Facades\DB;

class ListDataPengembalians extends ListRecords
{
    protected static string $resource = DataPengembalianResource::class;

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
            Action::make('kembalikan_peminjaman')->icon(Heroicon::Camera)
                ->label('Pengembalian')
                ->color('success')
                ->requiresConfirmation()
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

                    DB::transaction(function () use ($record) {
                        $record->update([
                            'status' => StatusPeminjaman::MENUNGGU_PERSETUJUAN,
                            'updated_by' => Auth::id()
                        ]);
                    });

                    Notification::make()
                        ->title('Barang berhasil discan')
                        ->body('Pengembalian Anda masih menunggu persetujuan dari Petugas')
                        ->success()
                        ->sendToDatabase(Auth::user());

                    // Toast (popup)
                    Notification::make()
                        ->title('Barang berhasil discan')
                        ->success()
                        ->send();
                }),
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

                    // Notifikasi langsung (popup)
                    Notification::make()
                        ->success()
                        ->title('Export Berhasil')
                        ->body('File laporan peminjaman sedang diunduh.')
                        ->duration(3000)
                        ->send();

                    // Notifikasi ke database
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
