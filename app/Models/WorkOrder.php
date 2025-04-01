<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'description',
        'status',
        'execution_deadline',
        'scheduled_date',
        'assigned_to',
        'quote_price',
        'comments',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

}
