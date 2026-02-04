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
        return Auth::user()?->role === HakAkses::SUPERADMIN;
    }

    protected ?string $heading = 'Pertumbuhan Ruangan Tahun Ini';

    protected function getData(): array
    {
        $year = now()->year;

        $dataDb = Ruangan::select(
            DB::raw('COUNT(id) as total'),
            DB::raw('MONTH(created_at) as month')
        )
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->translatedFormat('F');

            $found = $dataDb->first(
                fn($item) => $item->month == $i
            );

            $data[] = $found->total ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Ruangan Baru',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(99, 102, 241, 0.4)',
                        'rgba(129, 140, 248, 0.4)',
                        'rgba(165, 180, 252, 0.4)',
                        'rgba(139, 92, 246, 0.4)',
                        'rgba(167, 139, 250, 0.4)',
                        'rgba(196, 181, 253, 0.4)',
                        'rgba(221, 214, 254, 0.4)',
                        'rgba(199, 210, 254, 0.4)',
                        'rgba(165, 180, 252, 0.4)',
                        'rgba(139, 92, 246, 0.4)',
                        'rgba(167, 139, 250, 0.4)',
                        'rgba(196, 181, 253, 0.4)',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
