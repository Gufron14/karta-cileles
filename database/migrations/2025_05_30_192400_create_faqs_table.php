<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_create_faqs_table.php
public function up(): void
{
    Schema::create('faqs', function (Blueprint $table) {
        $table->id();
        $table->text('pertanyaan');
        $table->text('jawaban');
        $table->timestamp('created_at')->useCurrent();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
