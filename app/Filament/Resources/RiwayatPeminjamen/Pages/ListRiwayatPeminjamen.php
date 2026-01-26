<?php

namespace App\Filament\Resources\RiwayatPeminjamen\Pages;

use App\Filament\Resources\RiwayatPeminjamen\RiwayatPeminjamanResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

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
            Action::make('export-laporan-bulanan')
                ->label("Export Laporan")
                ->color(Color::Indigo)
                ->icon(Heroicon::OutlinedPrinter)
                ->requiresConfirmation()
                ->modalHeading('Export Laporan Peminjaman')
                ->modalIcon(Heroicon::Printer)
                ->modalDescription('Apakah Anda yakin ingin mengexport laporan peminjaman bulan ini?')
                ->modalSubmitActionLabel('Ya, Export')
                ->action(function () {
                    // Notifikasi langsung (popup)
                    Notification::make()
                        ->success()
                        ->title('Export Berhasil')
                        ->body('File laporan sedang diunduh.')
                        ->duration(3000)
                        ->send();

                    // Notifikasi ke database
                    Notification::make()
                        ->success()
                        ->title('Laporan Peminjaman Diexport')
                        ->body('Anda telah mengexport laporan peminjaman bulan ' . now()->locale('id')->isoFormat('MMMM YYYY'))
                        ->icon(Heroicon::DocumentText)
                        ->actions([
                            Action::make('view')
                                ->button()
                                ->url(route('export.peminjaman', ['bulan' => now()->format('Y-m')]))
                                ->openUrlInNewTab(),
                        ])
                        ->sendToDatabase(Auth::user());

                    return redirect()->route('export.peminjaman', ['bulan' => now()->format('Y-m')]);
                })
        ];
    }
}
