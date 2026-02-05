<?php

namespace App\Filament\Resources\PeminjamanBarangSuperAdmins\Pages;

use App\Filament\Resources\PeminjamanBarangSuperAdmins\PeminjamanBarangSuperAdminResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ListPeminjamanBarangSuperAdmins extends ListRecords
{
    protected static string $resource = PeminjamanBarangSuperAdminResource::class;

    public function getSubheading(): string|Htmlable|null
    {
        return 'Input peminjaman barang pengguna secara instan tanpa pengajuan';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('tambah_peminjaman')
                ->label('Buat Peminjaman')
                ->icon(Heroicon::Plus)
                ->color(Color::Indigo)
                ->modalHeading('Pilih Metode Input')
                ->modalDescription('Silakan pilih metode untuk menambahkan data peminjaman.')
                ->modalSubmitAction(false)
                ->modalIcon(Heroicon::OutlinedQuestionMarkCircle)
                ->modalWidth('md')
                ->closeModalByClickingAway(false)
                ->modalCancelActionLabel('Tutup')
                ->extraModalFooterActions([
                    Action::make('scan_barcode')
                        ->label('Scan Barcode')
                        ->icon(Heroicon::QrCode)
                        ->color('success'),
                        // ->url(route('scan.barcode.peminjaman')),

                    Action::make('input_manual')
                        ->label('Input Manual')
                        ->icon(Heroicon::PencilSquare)
                        ->color(Color::Indigo)
                        ->url(
                            PeminjamanBarangSuperAdminResource::getUrl('create')
                        ),
                ]),
        ];
    }
}
