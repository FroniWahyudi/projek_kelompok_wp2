<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'type',
    ];

    // ✅ Tambahkan ini
    protected $casts = [
        'date' => 'date',
    ];

    // Relasi ke User (karyawan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

