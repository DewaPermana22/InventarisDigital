<?php

namespace App\Filament\Widgets;

use App\Enums\HakAkses;
use App\Enums\KondisiBarang;
use App\Models\Barang;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class BarangStats extends StatsOverviewWidget
{
    public static function canView(): bool
    {
        return Auth::user()?->role == HakAkses::ADMIN;
    }

    protected function getHeading(): ?string
    {
        return "Statistik Barang";
    }
    protected function getStats(): array
    {
        return [
            Stat::make(
                'Kondisi Baik',
                Barang::where('kondisi', KondisiBarang::BAIK)->count()
            )
                ->description('Barang siap digunakan')
                ->descriptionIcon(Heroicon::OutlinedCheckCircle, IconPosition::Before)
                ->color('success'),

            Stat::make(
                'Kondisi Maintenance',
                Barang::where('kondisi', KondisiBarang::PERBAIKAN)->count()
            )
                ->description('Barang sedang diperbaiki')
                ->descriptionIcon(Heroicon::OutlinedWrenchScrewdriver, IconPosition::Before)
                ->color('warning'),

            Stat::make(
                'Kondisi Rusak',
                Barang::where('kondisi', KondisiBarang::RUSAK)->count()
            )
                ->description('Barang tidak dapat digunakan')
                ->descriptionIcon(Heroicon::OutlinedXCircle, IconPosition::Before)
                ->color('danger'),
        ];
    }
}
