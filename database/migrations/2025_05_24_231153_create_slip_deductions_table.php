<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
       Schema::create('slip_deductions', function (Blueprint $table) {
    $table->id();
    $table->string('slip_id');
    $table->string('name');      // ganti description → name
    $table->decimal('amount', 15, 2);
    $table->timestamps();

    $table->foreign('slip_id')
          ->references('id')
          ->on('slips')
          ->onDelete('cascade');
});

    }

    public function down()
    {
        Schema::dropIfExists('slip_deductions');
    }
};
