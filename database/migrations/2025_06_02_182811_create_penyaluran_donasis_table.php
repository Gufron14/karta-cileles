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
        Schema::create('penyaluran_donasis', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('donasi_id')->constrained('donasis')->onDelete('cascade');
            $table->date('tanggal');
            $table->decimal('uang_keluar', 15, 2);
            $table->string('alamat');
            $table->integer('jml_kpl_keluarga');
            $table->json('nam_kk')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['pending', 'terverifikasi'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyaluran_donasis');
    }
};
