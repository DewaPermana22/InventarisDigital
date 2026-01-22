<?php

namespace App\Filament\Widgets;

use App\Enums\HakAkses;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class GrafikPeminjaman extends ChartWidget
{

    public static function canView(): bool
    {
        return Auth::user()?->role == HakAkses::SUPERADMIN;
    }
    protected ?string $heading = 'Grafik Peminjaman';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Peminjaman',
                    'data' => [45, 32, 28, 15, 12, 8],
                    'backgroundColor' => [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(245, 158, 11, 0.7)',
                        'rgba(239, 68, 68, 0.7)',
                        'rgba(139, 92, 246, 0.7)',
                        'rgba(236, 72, 153, 0.7)',
                    ],
                    'borderColor' => [
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)',
                        'rgb(139, 92, 246)',
                        'rgb(236, 72, 153)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => [
                'Laptop',
                'Proyektor',
                'Kamera',
                'Sound System',
                'Microphone',
                'Tripod',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'polarArea';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
            ],
            'scales' => [
                'r' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'display' => true,
                        'stepSize' => 10,
                    ],
                    'grid' => [
                        'color' => 'rgba(0, 0, 0, 0.1)',
                    ],
                ],
            ],
        ];
    }
}
