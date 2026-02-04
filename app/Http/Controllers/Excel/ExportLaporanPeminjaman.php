<?php

namespace App\Http\Controllers\Excel;

use App\Exports\LaporanPeminjamanBarang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportLaporanPeminjaman extends Controller
{
    public function export(Request $request)
    {
        $filterType = $request->get('filter_type', 'tahun'); // 'bulan' atau 'tahun'
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun', now()->year);

        // Buat nama file berdasarkan filter
        if ($filterType === 'bulan' && $bulan) {
            $namaBulan = \Carbon\Carbon::create($tahun, $bulan)->locale('id')->translatedFormat('F_Y');
            $fileName = "Laporan_Peminjaman_{$namaBulan}_" . now()->format('Y-m-d_His') . ".xlsx";
        } else {
            $fileName = "Laporan_Peminjaman_Tahun_{$tahun}_" . now()->format('Y-m-d_His') . ".xlsx";
        }

        return Excel::download(
            new LaporanPeminjamanBarang($filterType, $bulan, $tahun),
            $fileName
        );
    }
}
