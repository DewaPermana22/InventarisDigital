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
                Barang::where('kondisi', KondisiBarang::BAIK)
                    ->count()
            )
                ->description('Jumlah pengguna aktif')
                ->descriptionIcon(Heroicon::OutlinedUsers, IconPosition::Before)
                ->color('success'),

            Stat::make(
                'Kondisi Maintenance',
                Barang::where('kondisi', KondisiBarang::PERBAIKAN)->count()
            )
                ->description('Jumlah barang tercatat dalam sistem')
                ->descriptionIcon(Heroicon::OutlinedCube)
                ->color('primary'),

            Stat::make(
                'Kondisi Rusak',
                Barang::where('kondisi', KondisiBarang::RUSAK)->count()
            )
                ->description('Jumlah ruangan terdaftar')
                ->descriptionIcon('heroicon-o-building-office')
                ->color('info'),
        ];
    }
}
