<?php

namespace App\Filament\Resources\Ruangans\Pages;

use App\Filament\Resources\Ruangans\RuanganResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Colors\Color;
use Illuminate\Contracts\Support\Htmlable;

class CreateRuangan extends CreateRecord
{
    protected static string $resource = RuanganResource::class;
    public function getHeading(): string|Htmlable
    {
        return 'Tambah Ruangan';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Lengkapi data ruangan yang akan di tambahkan';
    }

    public function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()->label('Simpan')
            ->color(Color::Indigo),
            $this->getCancelFormAction()->label('Batal')
            ->color('danger'),
        ];
    }
}
