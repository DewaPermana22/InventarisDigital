<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'InventarisDigital - Solusi Manajemen Inventaris Modern',
            'problems' => $this->getProblems(),
            'features' => $this->getFeatures(),
            'steps' => $this->getSteps(),
            'targets' => $this->getTargets(),
        ];

        return view('landing.index', $data);
    }

    public function pricing()
    {
        return view('landing.pricing');
    }

    public function scan()
    {
        return view('scanner.barcode');
    }

    private function getProblems()
    {
        return [
            [
                'icon' => 'file-x',
                'color' => 'red',
                'title' => 'Pencatatan Manual',
                'description' => 'Buku besar dan spreadsheet yang membingungkan dan rawan kesalahan input data.'
            ],
            [
                'icon' => 'search-slash',
                'color' => 'orange',
                'title' => 'Barang Hilang',
                'description' => 'Aset tidak terlacak dengan baik, sulit mengetahui siapa yang membawa barang saat ini.'
            ],
            [
                'icon' => 'bar-chart-3',
                'color' => 'amber',
                'title' => 'Sulit Rekap Laporan',
                'description' => 'Butuh waktu berjam-jam bahkan berhari-hari hanya untuk membuat satu laporan bulanan.'
            ],
        ];
    }

    private function getFeatures()
    {
        return [
            [
                'icon' => 'box',
                'title' => 'Manajemen Barang',
                'description' => 'Kategorikan aset, tambahkan spesifikasi, dan pantau kondisi fisik barang.'
            ],
            [
                'icon' => 'arrow-left-right',
                'title' => 'Peminjaman',
                'description' => 'Alur pengajuan pinjam dan kembali yang tercatat lengkap dengan tenggat waktu.'
            ],
            [
                'icon' => 'users',
                'title' => 'Manajemen User',
                'description' => 'Atur hak akses admin, operator, dan peminjam secara spesifik.'
            ],
            [
                'icon' => 'file-spreadsheet',
                'title' => 'Laporan Otomatis',
                'description' => 'Ekspor laporan bulanan atau riwayat peminjaman dalam satu klik.'
            ],
        ];
    }

    private function getSteps()
    {
        return [
            [
                'number' => 1,
                'title' => 'Input Data Barang',
                'description' => 'Daftarkan semua aset Anda ke dalam sistem, lengkap dengan foto dan kode inventaris unik untuk pelacakan mudah.'
            ],
            [
                'number' => 2,
                'title' => 'Proses Peminjaman',
                'description' => 'Peminjam melakukan scan atau memilih barang melalui portal. Admin menyetujui, dan status stok otomatis terupdate.'
            ],
            [
                'number' => 3,
                'title' => 'Monitoring & Laporan',
                'description' => 'Pantau siapa saja yang belum mengembalikan barang dan cetak laporan akhir periode secara otomatis dalam format PDF/Excel.'
            ],
        ];
    }

    private function getTargets()
    {
        return [
            [
                'icon' => 'graduation-cap',
                'title' => 'Sekolah / Kampus',
                'description' => 'Manajemen peralatan lab, alat olahraga, hingga buku perpustakaan.'
            ],
            [
                'icon' => 'building-2',
                'title' => 'Perusahaan',
                'description' => 'Inventaris laptop karyawan, proyektor ruang rapat, dan aset kantor lainnya.'
            ],
            [
                'icon' => 'briefcase',
                'title' => 'Organisasi / Instansi',
                'description' => 'Kelola peralatan komunitas atau perlengkapan acara dengan rapi.'
            ],
        ];
    }

    public function card(){
        return view('pdf.card');
    }
}
