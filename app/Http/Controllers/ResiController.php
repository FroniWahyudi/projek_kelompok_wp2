<?php

namespace App\Http\Controllers;

use App\Models\Resi;
use Illuminate\Http\Request;

class ResiController extends Controller
{
    public function index()
    {
        // Ambil semua resi beserta item dan checklist-nya
        $resiCollection = Resi::with('items.checklist')->get();

        // Format data menjadi struktur array yang siap dikirim ke view
        $data = $resiCollection->mapWithKeys(function ($r) {
            return [
                'resi' . $r->id => [
                    'kode'    => $r->kode,
                    'tujuan'  => $r->tujuan,
                    'tanggal' => \Carbon\Carbon::parse($r->tanggal)->format('d M Y'),
                    'status'  => $r->status,
                    'items'   => $r->items->map(fn($it) => [
                        'item'      => $it->nama_item,
                        'qty'       => $it->qty,
                        'checklist' => $it->checklist->map(fn($c) => [
                            'checked' => $c->is_checked,
                        ])->toArray(),
                    ])->values(),
                ]
            ];
        })->all();

        // Kirim data ke view laporan kerja
        return view('index.laporan_kerja', compact('data'));
    }
}
