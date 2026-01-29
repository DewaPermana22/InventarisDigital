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

    protected ?string $heading = 'Pertumbuhan Pengguna Tahun Ini';

    protected function getData(): array
    {
        $year = now()->year;

        $users = User::select(
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

            $found = $users->first(
                fn($item) => $item->month == $i
            );

            $data[] = $found->total ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pengguna Baru',
                    'data' => $data,
                    'borderColor' => '#6366F1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.3)',
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getMaxHeight(): ?string
    {
        return '300px';
    }
}
