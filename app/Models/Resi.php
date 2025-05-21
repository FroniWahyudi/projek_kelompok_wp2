<?php  
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Resi extends Model
{
    protected $table = 'resi';
    protected $fillable = ['kode','tujuan','tanggal','status'];

    public function items()
    {
        return $this->hasMany(ResiItem::class);
    }
}
