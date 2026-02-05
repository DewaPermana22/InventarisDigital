<?php

namespace App\Filament\Widgets;

use App\Enums\HakAkses;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Barang;
use App\Models\Ruangan;
use Filament\Support\Enums\IconPosition;
use Illuminate\Support\Facades\Auth;

class DashboardStats extends StatsOverviewWidget
{
    public static function canView(): bool
    {
        return Auth::user()?->role == HakAkses::SUPERADMIN;
    }
    
    protected function getStats(): array
    {
        return [
            Stat::make(
                'Total Pengguna',
                User::where('role', HakAkses::USER)
                    ->where('is_active', 1)
                    ->count()
            )
                ->description('Jumlah pengguna aktif')
                ->descriptionIcon(Heroicon::OutlinedUsers, IconPosition::Before)
                ->color('success'),

            Stat::make(
                'Total Barang',
                Barang::count()
            )
                ->description('Jumlah barang tercatat dalam sistem')
                ->descriptionIcon(Heroicon::OutlinedCube)
                ->color('primary'),

            Stat::make(
                'Total Ruangan',
                Ruangan::count()
            )
                ->description('Jumlah ruangan terdaftar')
                ->descriptionIcon('heroicon-o-building-office')
                ->color('info'),
        ];
    }
}
