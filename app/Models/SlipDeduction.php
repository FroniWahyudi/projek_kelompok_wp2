<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlipDeduction extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'slip_id',
        'name',
        'amount',
    ];

// SlipEarning.php
public function slip()
{
    return $this->belongsTo(Slip::class, 'slip_id');
}

}
