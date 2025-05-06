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
        Schema::create('dpjb_pasien_ranap', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("no_rawat");
            $table->uuid("dokter_dpjb");
            $table->boolean('dpjb_utama');
            $table->timestamps();

            $table->foreign('no_rawat')->references('no_rawat')->on('registrasi');
            $table->foreign('dokter_dpjb')->references('id')->on('dokter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dpjb_pasien_ranap');
    }
};
