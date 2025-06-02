<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_beritas_table.php
public function up(): void
{
    Schema::create('beritas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('bencana_id')->constrained('bencanas')->onDelete('cascade');
        $table->string('judul');
        $table->text('isi');
        $table->string('slug');
        $table->string('thumbnail')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
