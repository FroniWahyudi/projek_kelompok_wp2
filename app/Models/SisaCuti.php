<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SisaCuti extends Model
{
    protected $table = 'sisa_cuti'; // <-- Tambahkan baris ini

    // Non-incrementing primary key (composite)
    public $incrementing = false;
    protected $primaryKey = ['user_id', 'tahun'];

    // Kolom yang boleh di mass-assign
    protected $fillable = [
        'user_id',
        'tahun',
        'cuti_sisa',
        'cuti_terpakai',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
