<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemChecklistSeeder extends Seeder
{
    public function run()
    {
        // Inisialisasi semua item_checklist = false
        $items = DB::table('resi_item')->get(['id']);
        foreach ($items as $it) {
            DB::table('item_checklist')->insert([
                'resi_item_id' => $it->id,
                'is_checked'   => false,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}
