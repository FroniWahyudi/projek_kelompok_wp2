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
            $table->string('role')->default('user'); // default ke 'user'
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('photo_url')->default('img/default-avatar.jpg'); // default foto
            $table->text('bio')->nullable();
            $table->string('alamat')->nullable();
            $table->date('joined_at')->nullable(); // ubah ke nullable
            $table->string('education')->nullable();
            $table->string('department')->nullable();
            $table->string('level')->nullable();
            $table->text('job_descriptions')->nullable();
            $table->text('skills')->nullable();
            $table->text('achievements')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken()->nullable(); // lebih rapi pakai helper
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
