<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = "news";

    protected $fillable = [
        'date',
        'title',
        'image_url',
        'description',
        'link',
    ];

    protected $guarded = 'id';
}
