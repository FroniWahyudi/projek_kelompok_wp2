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
            'SPXID12345678'=>[
                ['Dokumen Pengiriman',1,null],
                ['Label Resi',5,null],
                ['Surat Jalan',2,null],
                ['Manifest Pengiriman',1,null],
                ['Tanda Terima',3,null],
            ],
            'SPXID23456789'=>[
                ['Dokumen Pengiriman',1,null],
                ['Label Resi',4,null],
                ['Surat Jalan',1,null],
                ['Manifest Pengiriman',1,null],
                ['Tanda Terima',2,null],
            ],
            'SPXID34567890'=>[
                ['Dokumen Pengiriman',2,15],
                ['Label Resi',6,15],
                ['Surat Jalan',2,15],
                ['Manifest Pengiriman',1,15],
                ['Tanda Terima',4,2],
            ],
            'SPXID45678901'=>[
                ['Dokumen Pengiriman',1,null],
                ['Label Resi',3,null],
                ['Surat Jalan',1,null],
                ['Manifest Pengiriman',1,null],
                ['Tanda Terima',2,null],
            ],
            'SPXID56789012'=>[
                ['Dokumen Pengiriman',1,2],
                ['Label Resi',5,3],
                ['Surat Jalan',2,15],
                ['Manifest Pengiriman',1,6],
                ['Tanda Terima',3,6],
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
