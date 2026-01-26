<?php

namespace App\Http\Controllers\Excel;

use App\Exports\RiwayatPeminjamanBarang;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportDataPeminjaman extends Controller
{
    public function export(Request $request)
    {
        $periode = Carbon::createFromFormat('Y-m', $request->bulan);
        $bulanTahun = $periode->format('F_Y');
        $fileName = "Laporan_Peminjaman_{$bulanTahun}_InventarisDigital.xlsx";
        return Excel::download(new RiwayatPeminjamanBarang($periode), $fileName);
    }
}
