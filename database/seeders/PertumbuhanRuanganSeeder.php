<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ruangan;
use Carbon\Carbon;

class PertumbuhanRuanganSeeder extends Seeder
{
    public function run(): void
    {
        // Nama ruangan realistis (Indonesia)
        $namaRuangan = [
            'Ruang Kelas X RPL 1',
            'Ruang Kelas X RPL 2',
            'Ruang Kelas XI RPL 1',
            'Ruang Kelas XI RPL 2',
            'Ruang Kelas XII RPL',
            'Laboratorium Komputer 1',
            'Laboratorium Komputer 2',
            'Laboratorium Jaringan',
            'Ruang Multimedia',
            'Ruang Server',
            'Ruang Guru',
            'Ruang Tata Usaha',
            'Ruang Praktik RPL',
            'Ruang Perpustakaan',
            'Ruang Rapat',
        ];

        // Jumlah ruangan baru per bulan (12 bulan terakhir)
        $monthlyRooms = [
            1, 1, 2, 1, 1, 2,
            1, 1, 2, 1, 1, 1
        ];

        $roomIndex = 0;

        foreach ($monthlyRooms as $index => $count) {
            $date = Carbon::now()->subMonths(11 - $index);

            for ($i = 0; $i < $count; $i++) {
                if (!isset($namaRuangan[$roomIndex])) {
                    return;
                }

                Ruangan::create([
                    'name' => $namaRuangan[$roomIndex],
                    'created_at' => $date->copy()->addDays(rand(1, 25)),
                    'updated_at' => now(),
                ]);

                $roomIndex++;
            }
        }
    }
}
