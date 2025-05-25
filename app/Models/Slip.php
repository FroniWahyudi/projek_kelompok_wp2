<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slip extends Model
{
    use HasFactory;

    // HAPUS baris berikut karena kamu tetap butuh ID:
    // public $incrementing = false;
    // protected $keyType = 'string';

    protected $fillable = [
        'slip_number',
        'user_id',
        'period',
        'net_salary',
        'status',
    ];

    protected $casts = [
        'period'     => 'date',
        'net_salary' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function earnings()
    {
        return $this->hasMany(SlipEarning::class, 'slip_id');
    }

    public function deductions()
    {
        return $this->hasMany(SlipDeduction::class, 'slip_id');
    }
}
