<?php  
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Resi extends Model
{
    protected $table = 'resi';
    protected $fillable = ['kode','tujuan','tanggal','status'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function items()
    {
        return $this->hasMany(ResiItem::class);
    }
}
