<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResiTable extends Migration
{
    public function up()
    {
        Schema::create('resi', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique()->comment('Contoh: SPXID12345678');
            $table->string('tujuan', 100);
            $table->date('tanggal');
            $table->enum('status', ['Pending', 'Selesai'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resi');
    }
}
