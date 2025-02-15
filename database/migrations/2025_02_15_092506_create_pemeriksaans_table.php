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
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->enum('lokasi_pemeriksaan', ['RALAN', 'RANAP'])->default('RALAN');
            $table->string("no_rawat", 20);
            $table->string("suhu_tubuh", 60)->nullable(true);
            $table->string("tensi", 60)->nullable(true);
            $table->string("nadi", 60)->nullable(true);
            $table->string("respirasi", 60)->nullable(true);
            $table->string("tinggi_badan", 60)->nullable(true);
            $table->string("berat", 60)->nullable(true);
            $table->string("spo2", 60)->nullable(true);
            $table->string("gcs", 60)->nullable(true);
            $table->enum("kesadaran", ['Compos Mentis', 'Somnolence', 'Sopor', 'Coma', 'Alert', 'Confusion', 'Voice', 'Pain', 'Unresponsive', 'Apatis', 'Delirium']);
            $table->text("keluhan")->nullable(true);
            $table->text("pemeriksaan")->nullable(true);
            $table->string("alergi")->nullable(true);
            $table->string("lingkar_perut", 20)->nullable(true);
            $table->text("rtl")->nullable(true);
            $table->text("penilaian")->nullable(true);
            $table->text("instruksi")->nullable(true);
            $table->text("evaluasi")->nullable(true);
            $table->timestamp('waktu_pemeriksaan');
            $table->uuid("pegawai");
            $table->timestamps();

            $table->foreign('pegawai')->references('id')->on('pegawai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaans');
    }
};
