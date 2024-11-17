<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pembelian_pakan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pakan');
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('kolam_id');
            $table->string('jumlah_pembelian');
            $table->timestamps();

            $table->foreign('kolam_id')->references('id')->on('kolam')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelian_pakan');
    }
};
