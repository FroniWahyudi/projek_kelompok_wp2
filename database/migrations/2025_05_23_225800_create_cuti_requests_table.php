<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('cuti_requests');
        Schema::create('cuti_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('lama_cuti');
            $table->text('alasan');
            $table->string('status')->default('Menunggu');
            $table->foreignId('disetujui_oleh')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            $table->date('tanggal_disetujui')
                  ->nullable();
            $table->text('catatan_hr')
                  ->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuti_requests');
    }
};
