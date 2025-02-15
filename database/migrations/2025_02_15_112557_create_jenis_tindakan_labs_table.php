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
        Schema::create('jenis_tindakan_lab', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("nama_perawatan");
            $table->double("total_tarif")->default(0);
            $table->double("bhp")->default(0);
            $table->double("kso")->default(0);
            $table->double("manajemen")->default(0);
            $table->double("bagian_rs")->default(0);
            $table->double("tarif_perujuk")->default(0);
            $table->double("tarif_dokter")->default(0);
            $table->double("tarif_petugas")->default(0);
            $table->enum("kategori", ['PK', 'PA', 'MB']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_tindakan_labs');
    }
};
