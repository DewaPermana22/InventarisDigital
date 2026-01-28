<?php

namespace App\Filament\Widgets;

use App\Enums\HakAkses;
use Filament\Widgets\ChartWidget;
use App\Models\PeminjamanBarang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GrafikPeminjaman extends ChartWidget
{
    public static function canView(): bool
    {
        return Auth::user()?->role == HakAkses::SUPERADMIN;
    }

    protected ?string $heading = 'Grafik Peminjaman (12 Bulan Terakhir)';

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }

    protected function getData(): array
    {
        $peminjaman = PeminjamanBarang::select(
            DB::raw('COUNT(id) as total'),
            DB::raw('MONTH(tanggal_pinjam) as month'),
            DB::raw('YEAR(tanggal_pinjam) as year')
        )
            ->where('tanggal_pinjam', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        $labels = [];
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->translatedFormat('M Y');

            $found = $peminjaman->first(
                fn($item) =>
                $item->month == $date->month && $item->year == $date->year
            );

            $data[] = $found->total ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Peminjaman',
                    'data' => $data,
                    'fill' => true, // AREA chart
                    'borderColor' => '#6366F1', // indigo-500
                    'backgroundColor' => 'rgba(99, 102, 241, 0.3)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // area = line + fill
    }

    protected function getMaxHeight(): ?string
    {
        return '300px';
    }
}
