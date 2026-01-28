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
        Schema::table('verifikasi_pengembalians', function (Blueprint $table) {
            $table->string('nama_bank')->after('metode_pembayaran')->nullable();
            $table->string('nama_ewallet')->after('nama_bank')->nullable();
            $table->double('total_bayar')->after('nama_ewallet')->nullable();
            $table->text('catatan')->after('terverifikasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('verifikasi_pengembalians', function (Blueprint $table) {
            $table->dropColumn('nama_bank');
            $table->dropColumn('nama_ewallet');
            $table->dropColumn('total_bayar');
            $table->dropColumn('catatan');
        });
    }
};
