<?php

namespace App\Exports;

use App\Enums\StatusPeminjaman;
use App\Models\PeminjamanBarang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class LaporanPeminjamanBarang implements FromView, WithEvents
{
    protected $filterType; // 'bulan' atau 'tahun'
    protected $bulan;
    protected $tahun;

    public function __construct($filterType = 'tahun', $bulan = null, $tahun = null)
    {
        $this->filterType = $filterType;
        $this->bulan = $bulan;
        $this->tahun = $tahun ?? now()->year;
    }

    public function view(): View
    {
        $query = PeminjamanBarang::with(['peminjam', 'barang', 'petugas'])
            ->where('status', StatusPeminjaman::DIKEMBALIKAN);

        if ($this->filterType === 'bulan' && $this->bulan) {
            $query->whereYear('tanggal_kembali', $this->tahun)
                ->whereMonth('tanggal_kembali', $this->bulan);
        } else {
            $query->whereYear('tanggal_kembali', $this->tahun);
        }

        $peminjamans = $query->orderBy('tanggal_kembali', 'desc')->get();

        // Format periode
        if ($this->filterType === 'bulan' && $this->bulan) {
            $namaBulan = \Carbon\Carbon::create($this->tahun, $this->bulan)->locale('id')->translatedFormat('F Y');
            $periode = "Periode: {$namaBulan}";
        } else {
            $periode = "Periode: Tahun {$this->tahun}";
        }

        return view('exports.laporan-peminjaman', [
            'peminjamans' => $peminjamans,
            'periode' => $periode,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge judul
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->mergeCells('A2:H2');
                $event->sheet->mergeCells('A3:H3');

                // Center judul
                foreach ([1, 2, 3] as $row) {
                    $event->sheet->getStyle("A{$row}")
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                // Bold judul
                $event->sheet->getStyle('A1:A3')->getFont()->setBold(true);

                // Header tabel (baris ke-5)
                $event->sheet->getStyle('A5:H5')->getFont()->setBold(true);
                $event->sheet->getStyle('A5:H5')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFFF00'); // Background kuning

                // Center align untuk header
                $event->sheet->getStyle('A5:H5')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                $highestRow = $event->sheet->getHighestRow();

                // BORDER untuk semua tabel (dari header sampai data terakhir)
                $event->sheet->getStyle("A5:H{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Auto width kolom
                foreach (range('A', 'H') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Footer dengan logo
                $footerRow = $highestRow + 2;

                // Logo di footer
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setPath(public_path('logo/inventarisdg_light.png'));
                $drawing->setHeight(40);
                $drawing->setCoordinates("A{$footerRow}");
                $drawing->setOffsetX(10);
                $drawing->setOffsetY(5);
                $drawing->setWorksheet($event->sheet->getDelegate());

                // Tinggi row footer untuk logo
                $event->sheet->getRowDimension($footerRow)->setRowHeight(35);

                // Text footer di sebelah kanan
                $footerTextRow = $footerRow;
                $event->sheet->mergeCells("C{$footerTextRow}:H{$footerTextRow}");
                $event->sheet->setCellValue("C{$footerTextRow}", 'Dibuat pada: ' . now()->format('d-m-Y H:i'));
                $event->sheet->getStyle("C{$footerTextRow}")
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }
}
