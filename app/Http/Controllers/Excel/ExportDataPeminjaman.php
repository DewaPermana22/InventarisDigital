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
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun', now()->year);

        if ($bulan) {
            $namaBulan = Carbon::create($tahun, $bulan)->locale('id')->translatedFormat('F_Y');
            $fileName = "Riwayat_Peminjaman_{$namaBulan}_" . now()->format('Y-m-d') . ".xlsx";
        } else {
            $fileName = "Riwayat_Peminjaman_Semua_" . now()->format('Y-m-d') . ".xlsx";
        }

        return Excel::download(
            new RiwayatPeminjamanBarang($bulan, $tahun),
            $fileName
        );
    }
}
