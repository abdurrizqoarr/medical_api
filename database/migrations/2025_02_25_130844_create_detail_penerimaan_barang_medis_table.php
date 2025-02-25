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
        Schema::create('detail_penerimaan_barang_medis', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("no_penerimaan", 40);
            $table->uuid("databarang");
            $table->integer("jumlah");
            $table->double("harga_terima");
            $table->double("presentase_diskon")->default(0);
            $table->double("total_harga_terima_sebelum_pajak");
            $table->double("presentase_pajak")->default(0);
            $table->double("total_harga_pesan_setelah_pajak");
            $table->string("rek_pebayaran")->nullable(true);
            $table->enum("status", ['BELUM DIBAYAR', 'SUDAH DIBAYAR'])->default('BELUM DIBAYAR');

            $table->timestamps();
            $table->foreign('databarang')->references('id')->on('data_barang');
            $table->foreign('no_penerimaan')->references('id')->on('penerimaan_barang_medis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_penerimaan_barang_medis');
    }
};
