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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("nik", 40)->unique(true);
            $table->string("npwp", 40)->nullable(true);
            $table->string("nip", 40)->unique(true);
            $table->string("nama", 240);
            $table->enum('jenis_kelamin', ['PRIA', 'WANITA']);
            $table->string('tempat_lahir', 120);
            $table->date('tanggal_lahir');
            $table->enum('stts_nikah', ['BELUM MENIKAH', 'MENIKAH', 'JANDA', 'DUDHA'])->nullable();
            $table->longText('alamat')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
