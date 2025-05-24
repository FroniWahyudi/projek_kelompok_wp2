<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\SisaCuti; // ← penting: tambahkan ini
use Illuminate\Database\Eloquent\Relations\HasOne; // ← penting: tambahkan ini juga

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";

    protected $fillable = [
        'name', 'role', 'email', 'phone', 'password',
        'photo_url', 'bio', 'alamat', 'joined_at',
        'education', 'department', 'level',
        'job_descriptions', 'skills', 'achievements',
        'divisi',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // === Relasi ke cuti requests ===
    public function cutiRequests()
    {
        return $this->hasMany(CutiRequest::class);
    }

    // === Relasi one-to-one ke sisa cuti ===
    public function sisaCuti(): HasOne
    {
        return $this->hasOne(SisaCuti::class, 'user_id');
    }
}
