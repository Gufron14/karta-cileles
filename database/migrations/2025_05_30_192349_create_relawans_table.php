<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_relawans_table.php
public function up(): void
{
    Schema::create('relawans', function (Blueprint $table) {
        $table->id();
        $table->string('nama_lengkap');
        $table->string('no_hp');
        $table->string('email');
        $table->text('alamat');
        $table->string('tempat_lahir');
        $table->date('tanggal_lahir');
        $table->string('jenis_kelamin');
        $table->string('pendidikan_terakhir');
        $table->string('usia');
        $table->string('ketertarikan');
        $table->string('kegiatan');
        $table->string('dokumentasi');
        $table->enum('status', ['aktif', 'pasif'])->default('aktif');
        $table->timestamp('created_at')->useCurrent();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relawans');
    }
};
