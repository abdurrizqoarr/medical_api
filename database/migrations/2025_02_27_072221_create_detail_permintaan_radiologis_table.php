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
        Schema::create('detail_permintaan_radiologi', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("id_permintaan_radiologi");
            $table->uuid("id_jenis_tindakan_radiologi");
            $table->enum("status", ['BELUM', 'SELESAI', 'BATAL'])->default('BELUM');
            $table->timestamps();
            $table->foreign('id_permintaan_radiologi')->references('id')->on('permintaan_radiologi');
            $table->foreign('id_jenis_tindakan_radiologi')->references('id')->on('jenis_tindakan_radiologi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_permintaan_radiologis');
    }
};
