<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'lease_id',
        'amount',
        'qr_code',
        'due_date',
        'status',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}
