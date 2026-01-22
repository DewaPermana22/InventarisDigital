<?php

namespace App\Service;

use App\Enums\KondisiBarang;
use App\Models\Barang;
use Milon\Barcode\DNS1D;
use Illuminate\Support\Facades\Storage;

class BarcodeBarangService
{
    protected $barcode;

    public function __construct()
    {
        $this->barcode = new DNS1D();
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
                'C128',
                3,
                50
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

    /**
     * Generate barcode untuk satu barang
     *
     * @param string $kodeBarang
     * @param bool $saveToFile
     * @return array
     */
    public function GenerateSingleBarcode($kodeBarang, $saveToFile = false)
    {
        $barang = Barang::where('kode_barang', $kodeBarang)->first();

        if (!$barang) {
            throw new \Exception("Barang dengan kode {$kodeBarang} tidak ditemukan");
        }

        // Generate barcode
        $barcodeImage = $this->barcode->getBarcodePNG(
            $barang->kode_barang,
            'C128',
            3,
            50
        );

        $result = [
            'kode_barang' => $barang->kode_barang,
            'name' => $barang->name,
            'barcode_base64' => $barcodeImage
        ];

        // Simpan ke file jika diminta
        if ($saveToFile) {
            $filename = 'barcodes/barang/' . $barang->kode_barang . '.png';
            Storage::put($filename, base64_decode($barcodeImage));

            $barang->update(['barcode_path' => $filename]);
            $result['barcode_path'] = $filename;
        }

        return $result;
    }
}
