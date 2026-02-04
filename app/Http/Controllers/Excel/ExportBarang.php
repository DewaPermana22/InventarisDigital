<?php

namespace App\Http\Controllers\Excel;

use App\Exports\BarangsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ExportBarang extends Controller
{
    public function export()
    {
        $fileName = "Data_Barang_InventarisDigital_" . now()->format('Y-m-d_His') . ".xlsx";
        return Excel::download(new BarangsExport(), $fileName);
    }
}
