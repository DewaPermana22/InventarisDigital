<?php

namespace App\Filament\Resources\RiwayatPeminjamen\Pages;

use App\Filament\Resources\RiwayatPeminjamen\RiwayatPeminjamanResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;
use Filament\Support\Icons\Heroicon;

class ListRiwayatPeminjamen extends ListRecords
{
    protected static string $resource = RiwayatPeminjamanResource::class;

    public function getSubheading(): string|Htmlable|null
    {
        return "Pantau status dan detail peminjaman barang Anda di sini.";
    }
    protected function getHeaderActions(): array
    {
        return [
            Action::make('export-riwayat')
                ->label("Export Riwayat")
                ->color(Color::Indigo)
                ->icon(Heroicon::OutlinedPrinter)
                ->requiresConfirmation()
                ->modalHeading('Export Riwayat Peminjaman')
                ->modalIcon(Heroicon::Printer)
                ->modalDescription('Pilih periode riwayat peminjaman yang ingin diexport')
                ->form([
                    Select::make('bulan')
                        ->label('Filter Bulan (Opsional)')
                        ->options(function () {
                            $bulanSekarang = now()->month;
                            $options = ['' => 'Semua Bulan'];

                            for ($i = 1; $i <= $bulanSekarang; $i++) {
                                $options[$i] = Carbon::create(null, $i)->locale('id')->translatedFormat('F');
                            }

                            return $options;
                        })
                        ->default('')
                        ->native(false)
                        ->placeholder('Pilih bulan (opsional)'),
                ])
                ->modalSubmitActionLabel('Ya, Export')
                ->action(function (array $data) {
                    $bulan = $data['bulan'] ?? null;
                    $tahun = now()->year;

                    // Notifikasi langsung (popup)
                    Notification::make()
                        ->success()
                        ->title('Export Berhasil')
                        ->body('File riwayat peminjaman sedang diunduh.')
                        ->duration(3000)
                        ->send();

                    // Notifikasi ke database
                    $periodeText = $bulan
                        ? Carbon::create($tahun, $bulan)->locale('id')->translatedFormat('F Y')
                        : "Semua Periode";

                    Notification::make()
                        ->success()
                        ->title('Riwayat Peminjaman berhasil di export')
                        ->body("Anda telah mengexport Riwayat Peminjaman ({$periodeText}) pada " . now()->format('d-m-Y'))
                        ->icon('heroicon-o-document-text')
                        ->actions([
                            Action::make('view')
                                ->button()
                                ->color(Color::Indigo)
                                ->label('Download Lagi')
                                ->url(route('export.riwayat-peminjaman', [
                                    'bulan' => $bulan,
                                    'tahun' => $tahun
                                ]))
                                ->openUrlInNewTab(),
                        ])
                        ->sendToDatabase(Auth::user());

                    return redirect()->route('export.riwayat-peminjaman', [
                        'bulan' => $bulan,
                        'tahun' => $tahun
                    ]);
                })
        ];
    }
}
