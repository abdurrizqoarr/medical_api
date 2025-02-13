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
        Schema::create('pasien', function (Blueprint $table) {
            $table->string('no_rm',10)->primary();
            $table->string('nama_pasien');
            $table->string('no_ktp', 40);
            $table->enum('jenis_kelamin', ['PRIA', 'WANITA']);
            $table->string('tempat_lahir', 200);
            $table->date('tanggal_lahir');
            $table->string('nama_ibu')->nullable();
            $table->longText('alamat');
            $table->enum('gol_darah', ['A', 'B', 'O', 'AB', '-']);
            $table->string('pekerjaan', 240)->nullable();
            $table->enum('stts_nikah', ['BELUM MENIKAH', 'MENIKAH', 'JANDA', 'DUDHA']);
            $table->string('agama', 120);
            $table->date('tgl_daftar');
            $table->string('no_tlp', 40)->nullable();
            $table->uuid('kelurahan')->nullable();
            $table->uuid('kecamatan')->nullable();
            $table->uuid('kabupaten')->nullable();
            $table->uuid('suku')->nullable();
            $table->uuid('bahasa')->nullable();
            $table->uuid('provinsi')->nullable();
            $table->uuid('cacat_fisik')->nullable();
            $table->uuid('pendidikan')->nullable();
            $table->uuid('keluarga')->nullable();

            $table->foreign('kelurahan')->references('id')->on('kelurahan')->onDelete('cascade');
            $table->foreign('kecamatan')->references('id')->on('kecamatan')->onDelete('cascade');
            $table->foreign('kabupaten')->references('id')->on('kabupaten')->onDelete('cascade');
            $table->foreign('suku')->references('id')->on('suku')->onDelete('cascade');
            $table->foreign('bahasa')->references('id')->on('bahasa')->onDelete('cascade');
            $table->foreign('provinsi')->references('id')->on('provinsi')->onDelete('cascade');
            $table->foreign('cacat_fisik')->references('id')->on('cacat_fisik')->onDelete('cascade');
            $table->foreign('pendidikan')->references('id')->on('pendidikan')->onDelete('cascade');
            $table->foreign('keluarga')->references('id')->on('keluarga')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
