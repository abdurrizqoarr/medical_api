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
        Schema::create('dokter', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("nama");
            $table->string("izin_praktek")->nullable(true);
            $table->uuid("spesialis");
            $table->uuid("pegawai");
            $table->timestamps();

            $table->foreign('spesialis')->references('id')->on('spesialis')->onDelete('cascade');
            $table->foreign('pegawai')->references('id')->on('pegawai')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokter');
    }
};
