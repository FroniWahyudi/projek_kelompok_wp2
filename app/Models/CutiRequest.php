<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CutiRequest extends Model
{
    // Kolom yang boleh di‐mass assign
    protected $fillable = [
        'user_id',
        'tanggal_pengajuan',
        'tanggal_mulai',
        'tanggal_selesai',
        'lama_cuti',
        'alasan',
        'status',
        'disetujui_oleh',
        'tanggal_disetujui',
        'catatan_hr',
    ];

    // Kolom yang secara otomatis di‐cast ke Carbon date
   protected $casts = [
    'tanggal_pengajuan' => 'date',
    'tanggal_mulai'     => 'date',
    'tanggal_selesai'   => 'date',
    'tanggal_disetujui' => 'date',
    'created_at'        => 'datetime',
    'updated_at'        => 'datetime',
];

    /**
     * Relasi ke User (pemohon)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke CutiLog
     */
    public function logs(): HasMany
    {
        return $this->hasMany(CutiLogs::class);
    }
}
