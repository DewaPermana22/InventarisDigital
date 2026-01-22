<?php

namespace App\Filament\Resources\PeminjamanBarangs\Pages;

use App\Filament\Resources\PeminjamanBarangs\PeminjamanBarangResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewPeminjamanBarang extends ViewRecord
{
    protected static string $resource = PeminjamanBarangResource::class;
    protected static ?string $breadcrumb = "Detail";
    public function getHeading(): string|Htmlable
    {
        return 'Detail Peminjaman ' . ($this->record->barang?->name ?? 'Peminjaman');
    }

    public function getBreadcrumbs(): array
    {
        return [
            static::getResource()::getUrl() => 'Peminjaman Barang',
            '#' => $this->record->barang->name,
        ];
    }
    public function getTitle(): string|Htmlable
    {
        return "Detail Peminjaman";
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
