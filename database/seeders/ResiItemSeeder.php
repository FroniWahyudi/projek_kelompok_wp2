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
                ['Sapu', 3,null],
                ['Pel Lantai', 2,null],
                ['Ember', 4,null],
                ['Kemoceng', 5,null],
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
                ['Paket Kardus', 10, 15],
                ['Lakban', 5, 15],
                ['Bubble Wrap', 3, 15],
                ['Timbangan Kecil', 2, 7],
                ['Plastik Sampah', 10, 2],
            ],
            'SPXID45678901' => [
                ['Sapu', 1, 5],
                ['Pel Lantai', 2, 6],
                ['Kemoceng', 3, 7],
                ['Ember', 4, 4],
                ['Sarung Tangan', 15, 3],
            ],
            'SPXID56789012' => [
                ['Hand Sanitizer', 12, 3],
                ['Masker', 30, 4],
                ['Tisu Basah', 20, 5],
                ['Kemoceng', 5, 6],
                ['Plastik Sampah', 15, 2],
                ['Lakban', 4, 3],
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
