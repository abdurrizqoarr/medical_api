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
        Schema::create('penerimaan_barang_medis', function (Blueprint $table) {
            $table->string("no_penerimaan")->primary();
            $table->string("no_pegajuan");
            $table->uuid("supplier");
            $table->uuid("depo_penerima");
            $table->uuid("pegawai_penerima");
            $table->timestamp("tanggal_penerimaan");
            $table->timestamp("tanggal_jatuh_tempo");
            $table->double("total_sebelum_pajak");
            $table->double("total_setelah_pajak");
            $table->string("rek_pebayaran")->nullable(true);
            $table->timestamps();

            $table->foreign('pegawai_penerima')->references('id')->on('pegawai');
            $table->foreign('supplier')->references('id')->on('supplier');
            $table->foreign('depo_penerima')->references('id')->on('depo_obat');
            $table->foreign('no_pegajuan')->references('no_pegajuan')->on('pengajuan_barang_medis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan_barang_medis');
    }
};
