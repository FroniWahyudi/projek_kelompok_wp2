<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetRequestsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('password_reset_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->index()->comment('ID pengguna yang mengajukan reset password');
            $table->text('keterangan')->comment('Alasan atau keterangan pengajuan reset password');
            $table->enum('status', ['pending', 'completed'])->default('pending')->comment('Status permintaan: pending atau completed');
            $table->string('token')->nullable()->unique()->comment('Token unik untuk verifikasi permintaan reset');
            $table->timestamp('expires_at')->nullable()->comment('Waktu kadaluarsa permintaan reset');
            $table->timestamps();
            $table->softDeletes()->comment('Waktu penghapusan lembut untuk menyimpan riwayat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('password_reset_requests');
    }
}