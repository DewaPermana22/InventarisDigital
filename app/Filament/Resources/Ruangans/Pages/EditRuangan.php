<?php

namespace App\Filament\Resources\Ruangans\Pages;

use App\Filament\Resources\Ruangans\RuanganResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRuangan extends EditRecord
{
    protected static string $resource = RuanganResource::class;

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()->label('Simpan Perubahan'),
            $this->getCancelFormAction()
                ->label('Batal')
                ->color('danger'),
        ];
    }

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
