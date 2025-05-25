// database/migrations/2025_05_25_000000_create_slips_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('slips', function (Blueprint $table) {
            $table->string('id')->primary();
            // ganti employee_id jadi user_id
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->date('period');
            $table->decimal('net_salary', 15, 2)->nullable();
            $table->enum('status', ['Draft','Terbit','Batal'])
                  ->default('Draft');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('slips');
    }
};
