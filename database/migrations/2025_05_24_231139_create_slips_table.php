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
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('slips');
    }
};
