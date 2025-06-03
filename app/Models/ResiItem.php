<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ResiItem extends Model
{
    protected $table = 'resi_item';
    protected $fillable = ['resi_id','nama_item','qty'];

    protected $casts = [
        'is_checked' => 'boolean',
    ];

    public function resi()
    {
        return $this->belongsTo(Resi::class);
    }
    public function checklist()
    {
        return $this->hasMany(ItemChecklist::class);
    }
}
