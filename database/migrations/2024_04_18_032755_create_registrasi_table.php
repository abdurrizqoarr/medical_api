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
        Schema::create('registrasi', function (Blueprint $table) {
            $table->string("no_rawat", 20)->primary();
            $table->timestamp("waktu_registrasi");
            $table->enum("status_periksa", ['Belum', 'Sudah', 'Batal', 'Berkas Diterima', 'Dirujuk', 'Meninggal'])->default('belum');
            $table->boolean("status_bayar")->default(false);
            $table->enum('status_rawat', ['RALAN', 'RANAP'])->default('RALAN');
            $table->uuid("poli");
            $table->uuid("dokter");
            $table->uuid("jaminan");
            $table->string("pasien");

            $table->foreign('poli')->references('id')->on('poli');
            $table->foreign('dokter')->references('id')->on('dokter');
            $table->foreign('jaminan')->references('id')->on('jaminan');
            $table->foreign('pasien')->references('no_rm')->on('pasien');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi');
    }
};
