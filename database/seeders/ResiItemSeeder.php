<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResiItemSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua resi
        $resi = DB::table('resi')->get(['id','kode']);

       $itemsByKode = [
            'SPXID12345678' => [
                ['Sapu', 3, null],
                ['Pel Lantai', 2, null],
                ['Ember', 4, null],
                ['Kemoceng', 5, null],
                ['Sarung Tangan', 10, null],
            ],
            'SPXID23456789' => [
                ['Detergen', 6, null],
                ['Sapu', 2, null],
                ['Pel Lantai', 3, null],
                ['Kemoceng', 4, null],
                ['Masker', 20, null],
            ],
            'SPXID34567890' => [
                ['Paket Kardus', 10, 6],
                ['Lakban', 5, 7],
                ['Bubble Wrap', 3, 9],
                ['Timbangan Kecil', 2, 15],
                ['Plastik Sampah', 10, 6],
            ],
            'SPXID45678901' => [
                ['Sapu', 1, 7],
                ['Pel Lantai', 2, 9],
                ['Kemoceng', 3, 15],
                ['Ember', 4, 6],
                ['Sarung Tangan', 15, 7],
            ],
            'SPXID56789012' => [
                ['Hand Sanitizer', 12, 9],
                ['Masker', 30, 15],
                ['Tisu Basah', 20, 6],
                ['Kemoceng', 5, 7],
                ['Plastik Sampah', 15, 9],
            ],
        ];

        foreach ($resi as $r) {
            foreach ($itemsByKode[$r->kode] as $itm) {
                DB::table('resi_item')->insert([
                    'resi_id'   => $r->id,
                    'nama_item' => $itm[0],
                    'qty'       => $itm[1],
                    'checked_by' => $itm[2], // ID user yang memeriksa item
                    'created_at'=> now(),
                    'updated_at'=> now(),
                ]);
            }
        }
    }
}
