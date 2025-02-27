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
        Schema::create('riwayat_kamar_inap_pasiens', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("no_rawat", 20);
            $table->uuid("id_bed");
            $table->double("tarif_harian");
            $table->timestamp("tanggal_masuk");
            $table->timestamp("tanggal_keluar");
            $table->double("tarif_total");
            $table->enum("status", ['PULANG ATAS PERSETUJUAN', 'PULANG ATAS PERMINTAAN SENDIRI', 'MENINGGAL',  'PULANG PAKSA']);
            $table->timestamps();

            $table->foreign('no_rawat')->references('no_rawat')->on('registrasi');
            $table->foreign('id_bed')->references('id')->on('bed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_kamar_inap_pasiens');
    }
};
