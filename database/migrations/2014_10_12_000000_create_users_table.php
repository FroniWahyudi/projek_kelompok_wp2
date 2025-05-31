<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('id_karyawan'); // Hapus after('id')
            $table->string('name');
            $table->string('role')->default('user');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('photo_url')->default('img/default-avatar.jpg');
            $table->text('bio')->nullable();
            $table->string('alamat')->nullable();
            $table->date('joined_at')->nullable();
            $table->string('education')->nullable();
            $table->string('department')->nullable();
            $table->string('level')->nullable();
            $table->text('job_descriptions')->nullable();
            $table->text('skills')->nullable();
            $table->text('achievements')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}