<?php

namespace App\Http\Controllers;

use App\Models\Resi;
use App\Models\ResiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ResiController extends Controller
{
    /**
     * Tampilkan daftar semua resi.
     */
public function index()
{
    $resi = Resi::with(['items', 'items.checkedBy'])->get();
    $resis = $resi->mapWithKeys(function ($r) {
        return [
            'resi' . $r->id => [
                'id'      => $r->id,
                'kode'    => $r->kode,
                'tujuan'  => $r->tujuan,
                'tanggal' => \Carbon\Carbon::parse($r->tanggal)->format('d M Y'),
                'status'  => $r->status,
                'items'   => $r->items->map(fn($it) => [
                    'id'        => $it->id,
                    'item'      => $it->nama_item,
                    'qty'       => $it->qty,
                    'is_checked' => $it->is_checked,
                    'checked_by' => $it->checkedBy ? $it->checkedBy->name : null,
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

        $data['status'] = 'Pending';
        $resi = Resi::create($data);
        $id_resi = Resi::select('id')->where('kode', $data['kode'])->first();
        // Simpan items ke ResiItem model
        foreach ($request['items'] as $item) {
            ResiItem::create([
                'resi_id'   => $id_resi->id,
                'nama_item' => $item['nama_item'],
                'qty'       => $item['qty'],
            ]);
        }

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
  /**
 * Hapus resi dari database.
 */
public function destroy($id)
{
    try {
        $resi = Resi::findOrFail($id);
        $resi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Resi berhasil dihapus.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus resi: ' . $e->getMessage()
        ], 500);
    }
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

     /**
     * (Metode AJAX) Update checklist item resi dan catat pengguna yang melakukan checklist.
     */
    public function updateChecklist(Request $request, $id)
    {
        // Pastikan pengguna adalah Leader atau Operator dengan job_descriptions "Inventory checker"
        if (Auth::user()->role === 'Leader' || (Auth::user()->role === 'Operator' && str_contains(Auth::user()->job_descriptions, 'Inventory checker'))) {
            $item = ResiItem::findOrFail($id);
            $isChecked = filter_var($request->input('is_checked'), FILTER_VALIDATE_BOOLEAN);
            $item->is_checked = $isChecked ? 1 : 0;
            $item->checked_by = $isChecked ? Auth::id() : null;
            $item->save();

            return response()->json([
                'success' => true,
                'message' => 'Checklist berhasil diperbarui.',
                'checked_by' => $item->checkedBy ? $item->checkedBy->name : null
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Akses ditolak. Anda tidak memiliki izin untuk mengubah checklist.'
        ], 403);
    }

    /**
 * Tampilkan halaman untuk cek inventaris.
 */
    /**
 * Arahkan ke laporan index untuk Leader atau Operator dengan job_descriptions "Inventory checker".
 */
public function checkInventory(Request $request)
{
    // Pastikan pengguna adalah Leader atau Operator dengan job_descriptions "Inventory checker"
    if (auth()->user()->role === 'Leader' || (auth()->user()->role === 'Operator' && str_contains(auth()->user()->job_descriptions, 'Inventory checker'))) {
        return redirect()->route('laporan.index');
    }

    // Jika tidak memenuhi syarat, redirect dengan pesan error
    return redirect()->route('laporan.index')->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
}
}
