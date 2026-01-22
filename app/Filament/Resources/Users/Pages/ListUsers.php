<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function getHeading(): string|Htmlable
    {
        return 'Data Pengguna';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Data pengguna yang terdaftar dalam sistem';
    }
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Tambah Pengguna')->icon(Heroicon::Plus)
            ->color(Color::Indigo),
        ];
    }
}
