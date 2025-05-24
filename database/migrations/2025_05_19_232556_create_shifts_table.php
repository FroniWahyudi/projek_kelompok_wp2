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
      Schema::create('shifts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->date('date');
    $table->enum('type', ['Pagi', 'Sore', 'Overtime']);
    $table->string('week_year'); // 🆕 Tambah minggu ke berapa
    $table->timestamps();

    $table->unique(['user_id', 'week_year']); // ✅ Batasi 1 shift per minggu
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
