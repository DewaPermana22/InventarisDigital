<?php

namespace App\Service;

use App\Models\Barang;
use Milon\Barcode\DNS2D;

class BarcodeBarangService
{
    protected $barcode;

    public function __construct()
    {
        $this->barcode = new DNS2D();
    }

    public function generateBarcodeForPrint($ids)
    {
        $barangs = Barang::whereIn('id', $ids)
            ->with('category')
            ->get();

        $barcodes = [];

        foreach ($barangs as $barang) {
            $barcodeImage = $this->barcode->getBarcodePNG(
                $barang->kode_barang,
                'QRCODE',
            );

            $barcodes[] = [
                'id' => $barang->id,
                'kode_barang' => $barang->kode_barang,
                'name' => $barang->name,
                'category' => $barang->category?->name,
                'barcode_base64' => $barcodeImage,
                'barcode_image' => 'data:image/png;base64,' . $barcodeImage
            ];
        }

        return [
            'barcodes' => $barcodes,
            'total' => count($barcodes),
            'generated_at' => now()->format('d/m/Y H:i:s')
        ];
    }
}
