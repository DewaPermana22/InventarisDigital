<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Service\BarcodeBarangService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class GenerateBarcodeBarang extends Controller
{
    /**
     * Download barcode sebagai PDF
     */
    public function download(Request $request)
    {
        $ids = $request->input('ids');

        $data = app(BarcodeBarangService::class)->generateBarcodeForPrint($ids);

        return Pdf::loadView(
            'pdf.barcode-barang',
            [
                'barcodes' => $data['barcodes'],
                'generatedAt' => $data['generated_at']
            ]
        )
            ->setPaper('a4', 'portrait')
            ->download('barcode-barang-' . now()->format('Ymd_His') . '.pdf');
    }
}
