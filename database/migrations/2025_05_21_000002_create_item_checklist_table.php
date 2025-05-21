<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemChecklistTable extends Migration
{
    public function up()
    {
        Schema::create('item_checklist', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resi_item_id')
                  ->constrained('resi_item')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->boolean('is_checked')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('item_checklist');
    }
}
