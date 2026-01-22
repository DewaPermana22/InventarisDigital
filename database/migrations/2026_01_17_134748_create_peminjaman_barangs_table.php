<?php

use App\Enums\StatusPeminjaman;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman_barangs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peminjam_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('petugas_id')->nullable()
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->restrictOnDelete();

            $table->date('tanggal_pinjam');
            $table->date('tanggal_disetujui')->nullable();
            $table->date('tanggal_kembali')->nullable();

            $table->enum('status', ['menunggu_persetujuan','dipinjam','dikembalikan','terlambat'])->default('menunggu_persetujuan');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_barangs');
    }
};
