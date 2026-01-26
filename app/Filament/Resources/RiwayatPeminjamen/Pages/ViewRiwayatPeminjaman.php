<?php

namespace App\Filament\Resources\RiwayatPeminjamen\Pages;

use App\Filament\Resources\RiwayatPeminjamen\RiwayatPeminjamanResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRiwayatPeminjaman extends ViewRecord
{
    protected static string $resource = RiwayatPeminjamanResource::class;
    protected static ?string $title = "Detail Peminjaman";

    public function getBreadcrumbs(): array
    {
        return [
            static::getResource()::getUrl() => 'Peminjaman Barang',
            '#' => $this->record->barang->name,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('kembali')
                ->label('Kembali')
                ->url($this->getResource()::getUrl('index'))
                ->color('danger'),
        ];
    }
}
