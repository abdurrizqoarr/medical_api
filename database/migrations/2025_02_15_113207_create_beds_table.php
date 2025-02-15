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
        Schema::create('beds', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("bed", 200)->unique(true);
            $table->uuid("bangsal");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('bangsal')->references('id')->on('bangsal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beds');
    }
};
