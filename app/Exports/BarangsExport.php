<?php

namespace App\Exports;

use App\Enums\KondisiBarang;
use App\Models\Barang;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class BarangsExport implements FromView, WithEvents
{
    public function view(): View
    {
        $barangs = Barang::with(['category', 'room'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('exports.barangs', [
            'barangs' => $barangs,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge judul
                $event->sheet->mergeCells('A1:G1');
                $event->sheet->mergeCells('A2:G2');
                $event->sheet->mergeCells('A3:G3');

                // Center judul
                foreach ([1, 2, 3] as $row) {
                    $event->sheet->getStyle("A{$row}")
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                // Bold judul
                $event->sheet->getStyle('A1:A3')->getFont()->setBold(true);

                // Header tabel (baris ke-5)
                $event->sheet->getStyle('A5:G5')->getFont()->setBold(true);
                $event->sheet->getStyle('A5:G5')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFFF00'); // Background kuning

                // Warna untuk kolom kondisi
                $highestRow = $event->sheet->getHighestRow();
                for ($row = 6; $row <= $highestRow; $row++) {
                    // Format Kondisi (kolom F)
                    $kondisi = strtolower($event->sheet->getCell("F{$row}")->getValue());
                    $event->sheet->setCellValue("F{$row}", strtoupper($kondisi));
                    $event->sheet->getStyle("F{$row}")->getFont()->setBold(true);

                    switch ($kondisi) {
                        case KondisiBarang::BAIK->value: // 'baik'
                            $event->sheet->getStyle("F{$row}")
                                ->getFont()->getColor()->setARGB('FF008000'); // hijau
                            break;
                        case KondisiBarang::RUSAK->value: // 'rusak'
                            $event->sheet->getStyle("F{$row}")
                                ->getFont()->getColor()->setARGB('FFFF0000'); // merah
                            break;
                        case KondisiBarang::PERBAIKAN->value: // 'perbaikan'
                            $event->sheet->getStyle("F{$row}")
                                ->getFont()->getColor()->setARGB('FFFFA500'); // kuning/orange
                            break;
                    }
                }

                // BORDER untuk semua tabel (dari header sampai data terakhir)
                $event->sheet->getStyle("A5:G{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Auto width kolom
                foreach (range('A', 'G') as $col) {
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
                $event->sheet->mergeCells("C{$footerTextRow}:G{$footerTextRow}");
                $event->sheet->setCellValue("C{$footerTextRow}", 'Dibuat pada: ' . now()->format('d-m-Y H:i'));
                $event->sheet->getStyle("C{$footerTextRow}")
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);
            },
        ];
    }
}
