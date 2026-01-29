<?php

namespace App\Filament\Widgets;

use App\Enums\HakAkses;
use App\Models\PeminjamanBarang;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class GrafikPinjambarang extends ChartWidget
{
    protected ?string $heading = 'Grafik Peminjaman Barang Tahun Ini';
    protected static ?int $sort = 1;
    public static function canView(): bool
    {
        return Auth::user()?->role === HakAkses::USER;
    }

    protected function getData(): array
    {
        $userId = Auth::id();
        $year = now()->year;

        $data = PeminjamanBarang::query()
            ->selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_pinjam', $year)
            ->where('peminjam_id', $userId)
            ->groupByRaw('MONTH(tanggal_pinjam)')
            ->orderByRaw('MONTH(tanggal_pinjam)')
            ->pluck('total', 'bulan');

        // Label bulan 1-12
        $labels = [];
        $values = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = Carbon::create()->month($i)->translatedFormat('F');
            $values[] = $data[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Peminjaman',
                    'data' => $values,
                    'fill' => true,
                    'tension' => 0.4,
                    'borderColor' => '#6366F1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.3)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    public function getColumnSpan(): int|string|array
    {
        return 'full';
    }

    protected function getMaxHeight(): ?string
    {
        return '300px';
    }

    protected function getType(): string
    {
        return 'line';
    }
}
