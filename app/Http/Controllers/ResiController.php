<?php

namespace App\Http\Controllers;

use App\Models\Resi;
use App\Models\ResiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ResiController extends Controller
{
    /**
     * Tampilkan daftar semua resi.
     */
   public function index()
{
    $resi = Resi::with('items.checklist')->get();
    $resis = $resi->mapWithKeys(function ($r) {
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
    return view('index.laporan_kerja', compact('resis'));
}

    /**
     * Tampilkan form untuk membuat resi baru.
     */
    public function create()
    {
        // <<< SESUAI: tampilkan halaman index/buat_resi.blade.php
        return view('index.buat_resi');
    }

    /**
     * Simpan resi baru ke database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kode'    => 'required|string|max:20|unique:resi,kode',
            'tujuan'  => 'required|string|max:100',
            'tanggal' => 'required|date',
        ]);

        $item = $request->input('items');

        $data['status'] = 'Pending';
        Resi::create($data);
        $id_resi = Resi::select('id')->where('kode', $data['kode'])->first();

        ResiItem::create([
            'resi_id' => $id_resi,
            'nama_item' => $item['nama_item'],
            'qty' => $item['qty'],
        ]);
        

        // <<< opsional: jika mau simpan items dari form
        // foreach ($request->items as $it) {
        //     $resi->items()->create($it);
        // }

        // <<< SESUAI: redirect ke laporan.index setelah simpan
        return redirect()->route('laporan.index')
                         ->with('success', 'Resi berhasil dibuat.');
    }

    /**
     * Tampilkan detail satu resi.
     */
    public function show(Resi $resi)
    {
        $resi->load('items.checklist');
        return view('resis.show', compact('resi'));
    }

    /**
     * Tampilkan form edit untuk resi tertentu.
     */
    public function edit(Resi $resi)
    {
        return view('resis.edit', compact('resi'));
    }

    /**
     * Simpan perubahan data resi.
     */
    public function update(Request $request, Resi $resi)
    {
        $data = $request->validate([
            'kode'    => 'required|string|max:20|unique:resi,kode,' . $resi->id,
            'tujuan'  => 'required|string|max:100',
            'tanggal' => 'required|date',
            'status'  => 'required|in:Pending,Selesai',
        ]);

        $resi->update($data);

        Session::flash('success', 'Resi berhasil diperbarui.');
        // <<< SESUAI: kembali ke laporan.index setelah update
        return redirect()->route('laporan.index');
    }

    /**
     * Hapus resi dari database.
     */
    public function destroy(Resi $resi)
    {
        $resi->delete();

        Session::flash('success', 'Resi berhasil dihapus.');
        // <<< SESUAI: kembali ke laporan.index setelah delete
        return redirect()->route('laporan.index');
    }

    /**
     * (Metode AJAX) Update hanya status resi berdasarkan kode.
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'kode'   => 'required|string',
            'status' => 'required|in:Pending,Selesai',
        ]);

        $resi = Resi::where('kode', $request->kode)->firstOrFail();
        $resi->status = $request->status;
        $resi->save();

        return response()->json(['message' => 'Status berhasil diperbarui.']);
    }
}
