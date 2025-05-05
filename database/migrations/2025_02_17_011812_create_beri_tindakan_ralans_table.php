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
        Schema::create('beri_tindakan_ralan', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("no_rawat");
            $table->uuid("dokter");
            $table->uuid("perawat");
            $table->string("nama_perawatan");
            $table->double("total_tarif");
            $table->double("bhp")->default(0);
            $table->double("kso")->default(0);
            $table->double("manajemen")->default(0);
            $table->double("material")->default(0);
            $table->double("tarif_dokter")->default(0);
            $table->double("tarif_perawat")->default(0);
            $table->timestamp("waktu_pemberian");

            $table->timestamps();

            $table->foreign('dokter')->references('id')->on('pegawai');
            $table->foreign('perawat')->references('id')->on('pegawai');
            $table->foreign('no_rawat')->references('no_rawat')->on('registrasi');
            $table->foreign('id_tindakan')->references('id')->on('jenis_tindakan_ralan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beri_tindakan_ralans');
    }
};
