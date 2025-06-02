<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('slips', function (Blueprint $table) {
            // Gunakan auto-increment integer sebagai primary key
            $table->increments('id');

            // Nomor slip khusus (SG-YYYY-XXX) disimpan di kolom terpisah
            $table->string('slip_number')->unique();

            // Relasi ke users
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->date('period');
            $table->decimal('net_salary', 15, 2)->nullable();
            $table->enum('status', ['Draft', 'Terbit', 'Batal'])
                  ->default('Draft');
            
            // Field untuk tracking status baca slip
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            
            $table->timestamps();
            
            // Index untuk performance query yang sering digunakan
            $table->index(['user_id', 'is_read']);
            $table->index(['period', 'is_read']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('slips');
    }
};