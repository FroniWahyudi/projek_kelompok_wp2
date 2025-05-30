<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('sisa_cuti');
        Schema::create('sisa_cuti', function (Blueprint $table) {
    $table->foreignId('user_id')
          ->constrained()
          ->onDelete('cascade');
    $table->integer('tahun')->default(now()->year);
    $table->integer('total_cuti')->default(0); // ✅ Tambahkan ini
    $table->integer('cuti_sisa')->default(0);
    $table->integer('cuti_terpakai')->default(0);
    $table->timestamps();

    $table->primary(['user_id', 'tahun']);
});

    }

    public function down(): void
    {
        Schema::dropIfExists('sisa_cuti');
    }
};
