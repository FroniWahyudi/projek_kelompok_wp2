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
                ['Dokumen Pengiriman',1],
                ['Label Resi',5],
                ['Surat Jalan',2],
                ['Manifest Pengiriman',1],
                ['Tanda Terima',3],
            ],
            'SPXID23456789'=>[
                ['Dokumen Pengiriman',1],
                ['Label Resi',4],
                ['Surat Jalan',1],
                ['Manifest Pengiriman',1],
                ['Tanda Terima',2],
            ],
            'SPXID34567890'=>[
                ['Dokumen Pengiriman',2],
                ['Label Resi',6],
                ['Surat Jalan',2],
                ['Manifest Pengiriman',1],
                ['Tanda Terima',4],
            ],
            'SPXID45678901'=>[
                ['Dokumen Pengiriman',1],
                ['Label Resi',3],
                ['Surat Jalan',1],
                ['Manifest Pengiriman',1],
                ['Tanda Terima',2],
            ],
            'SPXID56789012'=>[
                ['Dokumen Pengiriman',1],
                ['Label Resi',5],
                ['Surat Jalan',2],
                ['Manifest Pengiriman',1],
                ['Tanda Terima',3],
            ],
        ];

        foreach ($resi as $r) {
            foreach ($itemsByKode[$r->kode] as $itm) {
                DB::table('resi_item')->insert([
                    'resi_id'   => $r->id,
                    'nama_item' => $itm[0],
                    'qty'       => $itm[1],
                    'created_at'=> now(),
                    'updated_at'=> now(),
                ]);
            }
        }
    }
}
