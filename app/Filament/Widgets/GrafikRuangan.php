<?php

namespace App\Filament\Widgets;

use App\Enums\HakAkses;
use Filament\Widgets\ChartWidget;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GrafikRuangan extends ChartWidget
{
    public static function canView(): bool
    {
        return Auth::user()?->role == HakAkses::SUPERADMIN;
    }
    protected ?string $heading = 'Pertumbuhan Ruangan (12 Bulan Terakhir)';

    protected function getData(): array
    {
        $dataDb = Ruangan::select(
            DB::raw('COUNT(id) as total'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $labels = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->translatedFormat('M Y');

            $found = $dataDb->first(
                fn($item) =>
                $item->month == $date->month && $item->year == $date->year
            );

            $data[] = $found->total ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ruangan Baru',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
