<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Service\KartuAnggotaService;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Http\Request;

class GenerateKartuPeminjam extends Controller
{
    public function download(Request $request)
    {
        $ids = $request->input('ids');

        $data = app(KartuAnggotaService::class)->cetakKartu($ids);

        return SnappyPdf::loadView(
            'pdf.card',
            $data
        )
            ->setPaper('a4', 'portrait')
            ->setOption('margin-top', 0)
            ->setOption('margin-bottom', 0)
            ->setOption('margin-left', 0)
            ->setOption('margin-right', 0)
            ->setOption('enable-local-file-access', true)
            ->setOption('print-media-type', true)
            ->setOption('no-background', false)
            ->download('kartu-peminjam-' . now()->format('Ymd_His') . '.pdf');
    }
}
