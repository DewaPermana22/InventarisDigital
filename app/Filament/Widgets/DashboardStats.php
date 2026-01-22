<?php

namespace App\Filament\Widgets;

use App\Enums\HakAkses;
use App\Enums\KondisiBarang;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Barang;
use App\Models\Ruangan;
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
                User::where('role', 'user')
                    ->where('is_active', 1)
                    ->count()
            )
                ->description('Jumlah pengguna aktif')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('success'),

            Stat::make(
                'Total Barang',
                Barang::where('kondisi', KondisiBarang::BAIK)->count()
            )
                ->description('Jumlah barang dalam kondisi baik')
                ->descriptionIcon('heroicon-o-archive-box')
                ->color('primary'),

            Stat::make(
                'Total Ruangan',
                Ruangan::count()
            )
                ->description('Jumlah ruangan tersedia')
                ->descriptionIcon('heroicon-o-building-office')
                ->color('info'),
        ];
    }
}
