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
        Schema::create('data_barang', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Kolom auto-increment primary key
            $table->string('nama_brng');
            $table->uuid('satuan_besar');
            $table->uuid('satuan_kecil');
            $table->integer('isi');
            $table->integer('kapasitas');
            $table->double('h_dasar')->default(0);
            $table->double('h_beli')->default(0);
            $table->double('harga_karyawan')->default(0);
            $table->double('harga_jual')->default(0);
            $table->double('harga_bebas')->default(0);
            $table->uuid('jenis');
            $table->uuid('kategori');
            $table->uuid('golongan');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('satuan_besar')->references('id')->on('satuan')->onDelete('cascade');
            $table->foreign('satuan_kecil')->references('id')->on('satuan')->onDelete('cascade');
            $table->foreign('jenis')->references('id')->on('jenis')->onDelete('cascade');
            $table->foreign('kategori')->references('id')->on('kategori')->onDelete('cascade');
            $table->foreign('golongan')->references('id')->on('golongan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_barangs');
    }
};
