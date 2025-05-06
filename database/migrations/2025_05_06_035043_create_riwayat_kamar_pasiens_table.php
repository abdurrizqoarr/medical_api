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
        Schema::create('riwayat_kamar_pasien', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("no_rawat");
            $table->string("bed");
            $table->double("tarif_per_malam");
            $table->timestamp("waktu_mulai");
            $table->timestamp("waktu_selesai")->nullable(true);
            $table->integer("lama_inap")->default(0);
            $table->double("tarif_total_inap");
            $table->enum("status", ['AKTIF', 'PINDAH RUANGAN', 'PULANG ATAS PERSETUJUAN', 'PULANG ATAS PERMINTAAN SENDIRI', 'MENINGGAL',  'PULANG PAKSA'])->default('AKTIF');
            $table->timestamps();

            $table->foreign('no_rawat')->references('no_rawat')->on('registrasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_kamar_pasien');
    }
};
