<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ResiSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();

        $data = [
            ['kode'=>'SPXID12345678','tujuan'=>'Bangil First Mile Hub','tanggal'=>'2025-05-14','status'=>'Pending'],
            ['kode'=>'SPXID23456789','tujuan'=>'Surabaya Distribution Center','tanggal'=>'2025-05-14','status'=>'Pending'],
            ['kode'=>'SPXID34567890','tujuan'=>'Malang Sorting Center','tanggal'=>'2025-05-14','status'=>'Selesai'],
            ['kode'=>'SPXID45678901','tujuan'=>'Pasuruan Hub','tanggal'=>'2025-05-14','status'=>'Pending'],
            ['kode'=>'SPXID56789012','tujuan'=>'Sidoarjo Collection Point','tanggal'=>'2025-05-14','status'=>'Selesai'],
        ];

        foreach ($data as $row) {
            DB::table('resi')->insert(array_merge($row, [
                'created_at'=>$now,
                'updated_at'=>$now,
            ]));
        }
    }
}
