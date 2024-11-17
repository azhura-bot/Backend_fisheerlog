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
        Schema::create('daily_task', function (Blueprint $table) {
            $table->id();
            $table->string('nama_task');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['pending', 'completed']);
            $table->string('karyawan_username');
            $table->foreign('karyawan_username')->references('username')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('manager_id');
            $table->foreign('manager_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('due_date');
            $table->boolean('completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_task');
    }
};
