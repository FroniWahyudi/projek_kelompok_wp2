<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PasswordResetRequest extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'keterangan', 'status', 'token', 'expires_at'];

    /**
     * Relasi ke model User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
