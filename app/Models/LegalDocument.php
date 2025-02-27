<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegalDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'lease_id',
        'type',
        'file_path',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}
