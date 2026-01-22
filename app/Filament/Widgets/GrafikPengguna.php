<?php

namespace App\Filament\Widgets;

use App\Enums\HakAkses;
use Filament\Widgets\ChartWidget;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GrafikPengguna extends ChartWidget
{
    public static function canView(): bool
    {
        return Auth::user()?->role === HakAkses::SUPERADMIN;
    }
    
    protected ?string $heading = 'Pertumbuhan Pengguna (12 Bulan Terakhir)';

    protected function getData(): array
    {
        // Ambil data user per bulan (12 bulan terakhir)
        $users = User::select(
            DB::raw('COUNT(id) as total'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Siapkan label dan data default 0
        $labels = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->translatedFormat('M Y');

            $found = $users->first(
                fn($item) =>
                $item->month == $date->month && $item->year == $date->year
            );

            $data[] = $found->total ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pengguna Baru',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
