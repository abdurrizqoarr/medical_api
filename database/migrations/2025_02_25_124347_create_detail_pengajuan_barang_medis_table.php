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
        Schema::create('detail_pengajuan_barang_medis', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("no_pegajuan");
            $table->uuid("databarang");
            $table->integer("jumlah");
            $table->double("harga_pesan");
            $table->double("total_harga_pesan_sebelum_pajak");
            $table->double("presentase_pajak")->default(0);
            $table->double("total_harga_pesan_setelah_pajak");

            $table->timestamps();
            $table->foreign('databarang')->references('id')->on('data_barang');
            $table->foreign('no_pegajuan')->references('no_pegajuan')->on('pengajuan_barang_medis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengajuan_barang_medis');
    }
};
