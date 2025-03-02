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
        Schema::create('resume_ranap', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("no_rawat", 20)->unique(true);
            $table->uuid("dokter_dpjb");
            $table->timestamp("tanggal_masuk");
            $table->timestamp("tanggal_keluar");
            $table->timestamp("waktu_resume");
            $table->enum("status_pulang", ['SEMBUH', 'MEMBAIK', 'KEADAAN KHUSUS', 'MENINGGAL'])->default('SEMBUH');
            $table->text("keluhan_utama")->nullable(true);
            $table->text("jalannya_penyakit_selama_perawatan")->nullable(true);
            $table->text("pemeriksaan_radiologi")->nullable(true);
            $table->text("pemeriksaan_laboratorium")->nullable(true);
            $table->text("tindakan_operasi")->nullable(true);
            $table->text("riwayat_obat")->nullable(true);
            $table->text("riwayat_diet")->nullable(true);
            $table->text("obat_pulang")->nullable(true);
            $table->text("catatan")->nullable(true);
            $table->text("diagnosa_utama")->nullable(true);
            $table->text("diagnosa_sekunder")->nullable(true);
            $table->text("prosedur_utama")->nullable(true);
            $table->text("prosedur_sekunder")->nullable(true);
            $table->timestamps();
            $table->foreign('no_rawat')->references('no_rawat')->on('registrasi');
            $table->foreign('dokter_dpjb')->references('id')->on('pegawai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resume_ranaps');
    }
};
