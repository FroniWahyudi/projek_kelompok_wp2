<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('resi_item', function (Blueprint $table) {
            if (!Schema::hasColumn('resi_item', 'checked_by')) {
                $table->unsignedBigInteger('checked_by')->nullable()->after('is_checked');
                $table->foreign('checked_by')->references('id')->on('users')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('resi_item', function (Blueprint $table) {
            $table->dropForeign(['checked_by']);
            $table->dropColumn('checked_by');
        });
    }
};