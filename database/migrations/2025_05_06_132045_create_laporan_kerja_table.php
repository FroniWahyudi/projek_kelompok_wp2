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
        Schema::create('laporan_kerja', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('tanggal');
            $table->string('nama');
            $table->string('divisi');
            $table->text('deskripsi');
        });

        Schema::create('cuti_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->date("tanggal_pengajuan");
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->integer('lama_cuti');
            $table->text('alasan');
            $table->enum('status',['Menunggu','Disetujui','Ditolak']);
            $table->date('tanggal_disetujui');
            $table->text('catatan_hr');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('sisa_cuti', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->year('tahun');
            $table->integer('total_cuti');
            $table->integer('cuti_terpakai');
            $table->integer('cuti_sisa');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date');
            $table->string('title');
            $table->string('image_url');
            $table->text('description');
            $table->string('link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kerja');
        Schema::dropIfExists('cuti_requrest');
        Schema::dropIfExists('sisa_cuti');
        Schema::dropIfExists('cuti_logs');
        Schema::dropIfExists('news');
    }
};
