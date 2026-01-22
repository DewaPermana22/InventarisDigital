<?php

namespace App\Filament\Resources\KategoriBarangs\Pages;

use App\Filament\Resources\KategoriBarangs\KategoriBarangResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKategoriBarang extends CreateRecord
{
    public function getHeading(): string
    {
        return 'Tambah Kategori';
    }

    public function getSubheading(): ?string
    {
        return 'Buat kategori barang baru untuk mengelompokkan item Anda';
    }

    protected static string $resource = KategoriBarangResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()
                ->label('Simpan'),
            $this->getCancelFormAction()
                ->label('Batal')->color('danger'),
        ];
    }
}
