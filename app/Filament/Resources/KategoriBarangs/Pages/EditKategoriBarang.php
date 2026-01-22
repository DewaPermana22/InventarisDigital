<?php

namespace App\Filament\Resources\KategoriBarangs\Pages;

use App\Filament\Resources\KategoriBarangs\KategoriBarangResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditKategoriBarang extends EditRecord
{
    protected static string $resource = KategoriBarangResource::class;

    public function getTitle(): string
    {
        return 'Edit ' . $this->record->name;
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->label('Simpan Perubahan'),
            $this->getCancelFormAction()
                ->label('Batal')->color('danger'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
