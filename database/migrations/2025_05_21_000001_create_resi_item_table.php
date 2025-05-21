<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResiItemTable extends Migration
{
    public function up()
    {
        Schema::create('resi_item', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resi_id')
                  ->constrained('resi')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('nama_item', 100);
            $table->unsignedInteger('qty')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('resi_item');
    }
}
