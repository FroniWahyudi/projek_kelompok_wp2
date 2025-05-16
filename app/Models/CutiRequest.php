<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiRequest extends Model
{
    use HasFactory;

    protected $table = "cuti_requests";

    protected $fillable = [
        'user_id',
        'tanggal_pengajuan',
        'tanggal_mulai',
        'tanggal_selesai',
        'lama_cuti',
        'alasan',
        'status',
        'tanggal_disetujui',
        'catatan_hr',
        'created_at',
        'updated_at',
    ];

    protected $guarded = 'id';
}
