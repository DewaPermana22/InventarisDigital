<?php

namespace App\Http\Controllers\Excel;

use App\Enums\HakAkses;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportUserAccount extends Controller
{
    public function export(Request $request)
    {
        $role = $request->get('role');

        $roleEnum = null;
        if ($role && $role !== '') {
            try {
                $roleEnum = HakAkses::from($role);
            } catch (\Exception $e) {
                $roleEnum = null;
            }
        }

        $filterName = $roleEnum ? strtoupper($roleEnum->value) : 'SEMUA';
        $fileName = "Data_Akun_{$filterName}_" . now()->format('Y-m-d_His') . ".xlsx";

        return Excel::download(new UsersExport($roleEnum), $fileName);
    }
}
