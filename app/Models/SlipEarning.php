<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlipEarning extends Model
{
    use HasFactory;

    // Jika kamu tidak menggunakan timestamps di detail, bisa matikan:
    public $timestamps = false;

    // IZINKAN MASS ASSIGNMENT
    protected $fillable = [
        'slip_id',   // foreign key ke slips.id
        'name',      // nama komponen pendapatan
        'amount',    // jumlah nilai
    ];

  // SlipEarning.php
public function slip()
{
    return $this->belongsTo(Slip::class, 'slip_id');
}

}
