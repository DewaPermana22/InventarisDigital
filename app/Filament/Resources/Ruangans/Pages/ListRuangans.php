<?php

namespace App\Filament\Resources\Ruangans\Pages;

use App\Filament\Resources\Ruangans\RuanganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ListRuangans extends ListRecords
{
    protected static string $resource = RuanganResource::class;

    public function getHeading(): string|Htmlable
    {
        return 'Data Ruangan';
    }
    public function getSubheading(): string|Htmlable|null
    {
        return 'Daftar Ruangan yang terdaftar dalam sistem';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Tambah Ruangan')
            ->color(Color::Indigo)
            ->icon(Heroicon::Plus),
        ];
    }
}
