<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'slugId', 
        'unit_id', 
        'tenant_id', 
        'reason'
    ];

    /**
     * Relation avec l'unité (Unit).
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Relation avec le locataire (Tenant).
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
