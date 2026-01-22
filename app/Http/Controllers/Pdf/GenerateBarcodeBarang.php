<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Service\BarcodeBarangService;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class GenerateBarcodeBarang extends Controller
{
    /**
     * Download barcode sebagai PDF
     */
    public function download(Request $request)
    {
        $ids = $request->input('ids');

        $data = app(BarcodeBarangService::class)->generateBarcodeForPrint($ids);

        return SnappyPdf::loadView(
            'pdf.barcode-barang',
            [
                'barcodes' => $data['barcodes'],
                'generatedAt' => $data['generated_at']
            ]
        )
            ->setPaper('a4', 'portrait')
            ->setOption('margin-top', 5)
            ->setOption('margin-bottom', 5)
            ->setOption('margin-left', 5)
            ->setOption('margin-right', 5)
            ->setOption('enable-local-file-access', true)
            ->setOption('print-media-type', true)
            ->setOption('no-background', false)
            ->download('barcode-barang-' . now()->format('Ymd_His') . '.pdf');
    }

    /**
     * Download single barcode sebagai PNG
     */
    public function downloadImage($kodeBarang)
    {
        try {
            $result = app(BarcodeBarangService::class)->GenerateSingleBarcode($kodeBarang, false);

            $image = base64_decode($result['barcode_base64']);

            return Response::make($image, 200, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'attachment; filename="barcode-' . $kodeBarang . '.png"'
            ]);
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }
}
