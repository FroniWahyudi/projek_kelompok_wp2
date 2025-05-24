<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuti_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuti_request_id')
                  ->constrained('cuti_requests')
                  ->onDelete('cascade');
            $table->string('aksi');
            $table->foreignId('oleh_user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuti_logs');
    }
};
