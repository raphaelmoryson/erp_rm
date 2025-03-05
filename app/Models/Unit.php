<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'tenant_id',
        'type',
        'name',
        'area',
        'status',
        'initial_rent_price',
        'floor',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
