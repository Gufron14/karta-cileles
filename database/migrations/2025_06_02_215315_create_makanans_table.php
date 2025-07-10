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
        Schema::create('makanans', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_makanan');
            $table->integer('jumlah_makanan')->nullable();
            $table->string('satuan')->nullable();
            $table->string('nama_donatur');
            $table->date('tanggal');
            $table->enum('status', ['pending', 'terverifikasi'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('makanans');
    }
};
