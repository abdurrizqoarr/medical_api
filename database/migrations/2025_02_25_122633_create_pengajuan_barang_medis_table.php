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
        Schema::create('pengajuan_barang_medis', function (Blueprint $table) {
            $table->string("no_pegajuan", 40)->primary();
            $table->uuid("supplier");
            $table->uuid("pegawai_pengaju");
            $table->timestamp("tanggal_pengajuan");
            $table->double("total_sebelum_pajak");
            $table->double("total_setelah_pajak");
            $table->enum("status", ['PENGAJUAN', 'DITOLAK', 'PURCHASE ORDER', 'DITERIMA'])->default('PENGAJUAN');

            $table->timestamps();
           
            $table->foreign('pegawai_pengaju')->references('id')->on('pegawai');
            $table->foreign('supplier')->references('id')->on('supplier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_barang_medis');
    }
};
