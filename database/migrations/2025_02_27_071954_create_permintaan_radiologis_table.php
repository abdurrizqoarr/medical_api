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
        Schema::create('permintaan_radiologi', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("no_rawat", 20);
            $table->timestamp("waktu_permintaan");
            $table->timestamp("waktu_sampel");
            $table->timestamp("waktu_sampel");
            $table->timestamp("waktu_hasil");
            $table->uuid("dokter_perujuk");
            $table->text("informasi_tambahan");
            $table->text("diganosis_klinis");

            $table->timestamps();
            $table->foreign('no_rawat')->references('no_rawat')->on('registrasi');
            $table->foreign('dokter_perujuk')->references('id')->on('pegawai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_radiologis');
    }
};
