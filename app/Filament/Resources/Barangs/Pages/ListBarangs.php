<?php

namespace App\Filament\Resources\Barangs\Pages;

use App\Filament\Resources\Barangs\BarangResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class ListBarangs extends ListRecords
{
    protected static string $resource = BarangResource::class;

    public function getHeading(): string
    {
        return 'Data Barang';
    }

    public function getSubheading(): ?string
    {
        return 'Daftar dan kelola data barang dalam sistem inventaris';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Barang')
                ->icon(Heroicon::Plus)
                ->color(Color::Indigo),

                Action::make('export-data-barang')
                ->label("Export Data Barang")
                ->color('success')
                ->icon(Heroicon::OutlinedPrinter)
                ->requiresConfirmation()
                ->modalHeading('Export Data Barang')
                ->modalIcon(Heroicon::Printer)
                ->modalDescription('Apakah Anda yakin ingin mengexport data barang inventaris?')
                ->modalSubmitActionLabel('Ya, Export')
                ->action(function () {
                    // Notifikasi langsung (popup)
                    Notification::make()
                        ->success()
                        ->title('Export Berhasil')
                        ->body('File data barang sedang diunduh.')
                        ->duration(3000)
                        ->send();

                    // Notifikasi ke database
                    Notification::make()
                        ->success()
                        ->title('Data Barang berhasil di export')
                        ->body('Anda telah mengexport Data Barang Inventaris pada ' . now()->format('d-m-Y H:i'))
                        ->icon(Heroicon::OutlinedDocumentText)
                        ->actions([
                            Action::make('view')
                                ->button()
                                ->label('Download Lagi')
                                ->url(route('export.barangs'))
                                ->openUrlInNewTab(),
                        ])
                        ->sendToDatabase(Auth::user());

                    return redirect()->route('export.barangs');
                })

        ];
    }
}
