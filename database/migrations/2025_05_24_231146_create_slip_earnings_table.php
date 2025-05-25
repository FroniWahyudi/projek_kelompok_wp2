<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('slip_earnings', function (Blueprint $table) {
            $table->id();

         // ganti foreignId() dengan unsignedInteger()
$table->unsignedInteger('slip_id');
$table->foreign('slip_id')
      ->references('id')
      ->on('slips')
      ->onDelete('cascade');


            $table->string('name');
            $table->decimal('amount', 15, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('slip_earnings');
    }
};
