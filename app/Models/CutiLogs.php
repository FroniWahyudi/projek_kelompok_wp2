<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiLogs extends Model
{
    use HasFactory;

    protected $table = "cuti_logs";

    protected $fillable = [
        'cuti_request_id',
        'aksi',
        'oleh_user_id',
        'keterangan',
    ];

    protected $guarded = 'id';
}
