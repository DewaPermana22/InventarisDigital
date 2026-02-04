<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class UsersExport implements FromView, WithEvents
{
    protected $role;

    public function __construct($role = null)
    {
        $this->role = $role;
    }

    public function view(): View
    {
        $query = User::query();

        if ($this->role) {
            $query->where('role', $this->role);
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        $filterRole = $this->role
            ? 'Role: ' . $this->role->label()
            : 'Semua Role';

        return view('exports.users', [
            'users' => $users,
            'filter' => $filterRole,
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

                // Warna untuk kolom role dan status aktif
                $highestRow = $event->sheet->getHighestRow();
                for ($row = 6; $row <= $highestRow; $row++) {
                    // Format Role (kolom E)
                    $role = strtolower($event->sheet->getCell("E{$row}")->getValue());
                    $event->sheet->setCellValue("E{$row}", strtoupper($role));
                    $event->sheet->getStyle("E{$row}")->getFont()->setBold(true);

                    switch ($role) {
                        case 'superadmin':
                            $event->sheet->getStyle("E{$row}")
                                ->getFont()->getColor()->setARGB('FFFF0000'); // merah
                            break;
                        case 'admin':
                        case 'petugas':
                            $event->sheet->getStyle("E{$row}")
                                ->getFont()->getColor()->setARGB('FFFF8C00'); // orange
                            break;
                        case 'user':
                            $event->sheet->getStyle("E{$row}")
                                ->getFont()->getColor()->setARGB('FF0000FF'); // biru
                            break;
                    }

                    // Format Status Aktif (kolom F)
                    $status = strtolower($event->sheet->getCell("F{$row}")->getValue());
                    $event->sheet->setCellValue("F{$row}", strtoupper($status));
                    $event->sheet->getStyle("F{$row}")->getFont()->setBold(true);

                    if ($status === 'aktif') {
                        $event->sheet->getStyle("F{$row}")
                            ->getFont()->getColor()->setARGB('FF008000'); // hijau
                    } else {
                        $event->sheet->getStyle("F{$row}")
                            ->getFont()->getColor()->setARGB('FFFF0000'); // merah
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

                // Note Password
                $noteRow = $highestRow + 2;
                $event->sheet->mergeCells("A{$noteRow}:G{$noteRow}");
                $event->sheet->setCellValue("A{$noteRow}", 'Note: Password dapat berubah jika pernah diubah sebelumnya');
                $event->sheet->getStyle("A{$noteRow}")->getFont()->setBold(true);
                $event->sheet->getStyle("A{$noteRow}")->getFont()->setItalic(true);

                // Footer dengan logo
                $footerRow = $highestRow + 4;

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
