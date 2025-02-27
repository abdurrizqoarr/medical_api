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
        Schema::create('sub_jenis_tindakan_labs', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("id_jenis_tindakan_lab");
            $table->string("sub_nama_pemeriksaan");
            $table->string("satuan");
            $table->string("nilai_rujukan");
            $table->timestamps();

            $table->foreign('id_jenis_tindakan_lab')->references('jenis_tindakan_lab')->on('bangsal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_jenis_tindakan_labs');
    }
};
