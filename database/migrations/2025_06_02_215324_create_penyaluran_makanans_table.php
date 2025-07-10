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
        Schema::create('penyaluran_makanans', function (Blueprint $table) {
            $table->id();
            $table->integer('jumlah');
            $table->string('alamat');
            $table->integer('jml_kk');
            $table->json('nama_kk')->nullable();
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
        Schema::dropIfExists('penyaluran_makanans');
    }
};
