<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_dokumentasi_bencanas_table.php
public function up(): void
{
    Schema::create('dokumentasi_bencanas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('bencana_id')->constrained('bencanas')->onDelete('cascade');
        $table->enum('jenis_media', ['foto', 'video']);
        $table->string('file_path');
        $table->string('keterangan')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumentasi_bencanas');
    }
};
