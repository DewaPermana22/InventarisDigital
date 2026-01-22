<?php

namespace App\Filament\Resources\PeminjamanBarangs\Pages;

use App\Filament\Resources\PeminjamanBarangs\PeminjamanBarangResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

class CreatePeminjamanBarang extends CreateRecord
{
    public function getHeading(): string|Htmlable
    {
        return "Ajukan Peminjaman Barang";
    }
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['peminjam_id'] = Auth::user()->id;
        return $data;
    }

    protected static string $resource = PeminjamanBarangResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()->label('Simpan')
                ->color(Color::Indigo),
            $this->getCancelFormAction()
                ->label('Batal')->color('danger')
        ];
    }
}
