<?php

namespace App\Http\Controllers\Pdf;

use App\Http\Controllers\Controller;
use App\Service\KartuAnggotaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class GenerateKartuPeminjam extends Controller
{
    public function download(Request $request)
    {
        $ids = $request->input('ids');

        $data = app(KartuAnggotaService::class)->cetakKartu($ids);

        return Pdf::loadView(
            'pdf.card',
            $data
        )
            ->setPaper('a4', 'landscape')
            ->download('kartu-peminjam-' . now()->format('Ymd_His') . '.pdf');
    }
}
