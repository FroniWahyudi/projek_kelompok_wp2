<?php  
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ItemChecklist extends Model
{
    protected $table = 'item_checklist';
    protected $fillable = ['resi_item_id','is_checked'];

    public function item()
    {
        return $this->belongsTo(ResiItem::class, 'resi_item_id');
    }
}
