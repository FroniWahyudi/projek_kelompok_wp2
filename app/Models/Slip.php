<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slip extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'user_id',      // ganti di sini
        'period',
        'net_salary',
        'status',
    ];

    protected $casts = [
        'period'     => 'date',
        'net_salary' => 'decimal:2',
    ];

    // relasi ke User
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    // relasi earnings & deductions sama seperti sebelumnya
    public function earnings()
    {
        return $this->hasMany(SlipEarning::class);
    }

    public function deductions()
    {
        return $this->hasMany(SlipDeduction::class);
    }
}
