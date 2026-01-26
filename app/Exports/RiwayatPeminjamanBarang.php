<?php

namespace App\Exports;

use App\Enums\StatusPeminjaman;
use App\Models\PeminjamanBarang;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class RiwayatPeminjamanBarang implements FromView, WithEvents
{
    protected $bulan;

    public function __construct($bulan = null)
    {
        $this->bulan = $bulan;
    }

    public function view(): View
    {
        $query = PeminjamanBarang::with(['peminjam', 'barang', 'petugas'])->where('peminjam_id', Auth::user()?->id);
        if ($this->bulan) {
            $query->whereMonth('tanggal_pinjam', $this->bulan);
        }

        $peminjamans = $query->get();

        $namaBulan = $this->bulan
            ? $this->bulan->translatedFormat('F Y')
            : 'Semua Periode';


        return view('exports.peminjaman', [
            'peminjamans' => $peminjamans,
            'periode' => $namaBulan,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

            // Logo
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setPath(public_path('logo/inventarisdg_light.png'));
                $drawing->setHeight(60);
                $drawing->setCoordinates('A1');
                $drawing->setWorksheet($event->sheet->getDelegate());

                // Merge judul
                $event->sheet->mergeCells('A1:I1');
                $event->sheet->mergeCells('A2:I2');
                $event->sheet->mergeCells('A3:I3');

                // Center judul
                foreach ([1, 2, 3] as $row) {
                    $event->sheet->getStyle("A{$row}")
                        ->getAlignment()
                        ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }

                // Bold judul
                $event->sheet->getStyle('A1:A3')->getFont()->setBold(true);

                // Header tabel (baris ke-5)
                $event->sheet->getStyle('A5:I5')->getFont()->setBold(true);
                $event->sheet->getStyle('A5:I5')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFFF00'); // Background kuning

                // Warna status
                $highestRow = $event->sheet->getHighestRow();
                for ($row = 6; $row <= $highestRow; $row++) {
                    $status = strtolower($event->sheet->getCell("I{$row}")->getValue());

                    // Ubah text jadi UPPERCASE dan BOLD
                    $event->sheet->setCellValue("I{$row}", strtoupper($status));
                    $event->sheet->getStyle("I{$row}")->getFont()->setBold(true);

                    // Set warna berdasarkan status
                    switch ($status) {
                        case StatusPeminjaman::DIKEMBALIKAN->value: // 'dikembalikan'
                            $event->sheet->getStyle("I{$row}")
                                ->getFont()->getColor()->setARGB('FF008000'); // hijau
                            break;

                        case StatusPeminjaman::DITOLAK->value: // 'ditolak'
                        case StatusPeminjaman::TERLAMBAT->value: // 'terlambat'
                            $event->sheet->getStyle("I{$row}")
                                ->getFont()->getColor()->setARGB('FFFF0000'); // merah
                            break;

                        case StatusPeminjaman::DIBATALKAN->value: // 'dibatalkan'
                            $event->sheet->getStyle("I{$row}")
                                ->getFont()->getColor()->setARGB('FFFF8C00'); // orange
                            break;
                    }
                }


                // BORDER untuk semua tabel (dari header sampai data terakhir)
                $event->sheet->getStyle("A5:I{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Auto width kolom
                foreach (range('A', 'I') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Footer
                $footerRow = $highestRow + 2;
                $event->sheet->mergeCells("A{$footerRow}:C{$footerRow}");
                $event->sheet->setCellValue("A{$footerRow}", 'Dibuat pada: ' . now()->format('d-m-Y H:i'));
            },
        ];
    }
}
