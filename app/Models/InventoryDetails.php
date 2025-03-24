<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryDetails extends Model
{
    use HasFactory;

    protected $table = 'inventory_details';

    protected $fillable = [
        'inventory_id',
        'element',
        'etat',
        'remarques',
        'photo',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
