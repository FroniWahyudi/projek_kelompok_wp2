<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resi extends Model
{
    protected $table = 'resi';
    protected $fillable = ['kode', 'tujuan', 'tanggal', 'status'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(ResiItem::class, 'resi_id');
    }

    // Menambahkan event deleting untuk menghapus item terkait
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($resi) {
            $resi->items()->delete(); // Hapus semua item terkait saat resi dihapus
        });
    }
}