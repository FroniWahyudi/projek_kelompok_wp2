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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('photo_url')->nullable();
            $table->text('bio')->nullable();
            $table->string('alamat')->nullable();
            $table->date('joined_at');
            $table->string('education')->nullable();
            $table->string('department')->nullable();
            $table->string('level')->nullable();
            $table->text('job_descriptions')->nullable();
            $table->text('skills')->nullable();
            $table->text('achievements')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
