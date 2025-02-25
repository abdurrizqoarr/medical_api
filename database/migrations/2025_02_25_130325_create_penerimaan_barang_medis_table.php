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
            $table->string("no_penerimaan", 40)->primary();
            $table->string("no_pegajuan", 40);
            $table->uuid("supplier");
            $table->uuid("depo_penerima");
            $table->uuid("pegawai_penerima");
            $table->timestamp("tanggal_penerimaan");
            $table->timestamp("tanggal_jatuh_tempo");
            $table->double("total_sebelum_pajak");
            $table->double("total_setelah_pajak");
            $table->double("potongan_kumulatif")->default(0);
            $table->double("total_akhir");
            $table->timestamps();

            $table->foreign('pegawai_penerima')->references('id')->on('pegawai');
            $table->foreign('supplier')->references('id')->on('supplier');
            $table->foreign('supplier')->references('id')->on('supplier');
            $table->foreign('no_pegajuan')->references('id')->on('pengajuan_barang_medis');
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
