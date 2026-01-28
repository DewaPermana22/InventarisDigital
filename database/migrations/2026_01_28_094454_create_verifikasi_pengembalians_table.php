<?php

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
        Schema::create('verifikasi_pengembalians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')
            ->constrained('peminjaman_barangs')->cascadeOnDelete();
            $table->string('metode_pembayaran');
            $table->text('path_bukti_pembayaran')->nullable();
            $table->boolean('terverifikasi')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasi_pengembalians');
    }
};
