<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_bantuan_tersedia_table.php
public function up(): void
{
    Schema::create('bantuan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('bencana_id')->constrained('bencanas')->onDelete('cascade');
        $table->enum('jenis_bantuan', ['pakaian', 'makanan', 'uang', 'lainnya']);
        $table->integer('jumlah');
        $table->string('satuan')->nullable();
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bantuans');
    }
};
