<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SisaCuti extends Model
{
    use HasFactory;

    protected $table = "sisa_cuti";

    protected $fillable = [
        'user_id',
        'tahun',
        'total_cuti',
        'cuti_terpakai',
        'cuti_sisa',
    ];

    protected $guarded = 'id';
}
