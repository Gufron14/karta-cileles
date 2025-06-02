<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_donasis_table.php
public function up(): void
{
    Schema::create('donasis', function (Blueprint $table) {
        $table->id();
        $table->string('nama_donatur');
        $table->string('email');
        $table->string('no_hp');
        $table->text('catatan')->nullable();
        $table->decimal('nominal', 12, 2);
        $table->string('bukti_transfer');
        $table->enum('status', ['pending', 'terverifikasi'])->default('pending');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasis');
    }
};
