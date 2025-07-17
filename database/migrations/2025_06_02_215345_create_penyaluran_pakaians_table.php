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
        Schema::create('penyaluran_pakaians', function (Blueprint $table) {
            $table->id();
            $table->json('pakaian_data');
            $table->date('tanggal');
            $table->enum('status', ['pending', 'disalurkan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyaluran_pakaians');
    }
};
