<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKerja extends Model
{
    use HasFactory;

    protected $table = "laporan_kerja";

    protected $fillable = [
        'tanggal',
        'nama',
        'divisi',
        'deskripsi',
    ];

    protected $guarded = 'id';
}
