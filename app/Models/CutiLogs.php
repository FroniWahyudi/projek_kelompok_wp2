<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CutiLogs extends Model
{
    // Kolom yang boleh di mass-assign
    protected $fillable = [
        'cuti_request_id',
        'aksi',
        'oleh_user_id',
        'keterangan',
    ];

    /**
     * Relasi ke CutiRequest
     */
    public function cutiRequest(): BelongsTo
    {
        return $this->belongsTo(CutiRequest::class);
    }

    /**
     * Relasi ke User (yang melakukan aksi)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'oleh_user_id');
    }
}
