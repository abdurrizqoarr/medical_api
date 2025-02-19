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
        Schema::create('permintaan_kamar_inap', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("no_rawat");
            $table->uuid("petugas_pemohon");
            $table->uuid("petugas_penerima")->nullable(true);
            $table->uuid("bed");
            $table->uuid("bed_akhir")->nullable(true);
            $table->string("diagnosa_awal");
            $table->timestamp("waktu_permintaan");
            $table->enum("status", ['PENDING', 'DITERIMA', 'BATAL'])->default('PENDING');
            $table->timestamps();

            $table->foreign('petugas_pemohon')->references('id')->on('pegawai');
            $table->foreign('petugas_penerima')->references('id')->on('pegawai');
            $table->foreign('no_rawat')->references('no_rawat')->on('registrasi');
            $table->foreign('bed')->references('id')->on('bed');
            $table->foreign('bed_akhir')->references('id')->on('bed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_kamar_inaps');
    }
};
