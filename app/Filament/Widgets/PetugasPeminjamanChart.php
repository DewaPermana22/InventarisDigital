<?php

namespace App\Filament\Widgets;

use App\Enums\HakAkses;
use App\Models\PeminjamanBarang;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class PetugasPeminjamanChart extends ChartWidget
{
    protected ?string $heading = "Data Peminjaman yang Disetujui per Bulan";

    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return Auth::user()?->role == HakAkses::ADMIN;
    }

    protected function getData(): array
    {
        $userId = Auth::id();
        $year = Carbon::now()->year;

        $data = PeminjamanBarang::query()
            ->selectRaw('MONTH(tanggal_disetujui) as bulan, COUNT(*) as total')
            ->where('petugas_id', $userId)
            ->whereYear('tanggal_disetujui', $year)
            ->whereNotNull('tanggal_disetujui')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $labels = [];
        $values = [];
        for ($m = 1; $m <= 12; $m++) {
            $labels[] = Carbon::create($year, $m, 1)->format('M');
            $values[] = $data[$m] ?? 0;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Peminjaman Disetujui',
                    'data' => $values,
                    'fill' => true,
                    'borderColor' => '#6366F1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.3)',
                    'tension' => 0.4,
                ],
            ],
        ];
    }


    protected function getType(): string
    {
        return 'line';
    }

    protected function getMaxHeight(): ?string
    {
        return '300px';
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }
}
