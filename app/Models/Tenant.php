<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'lastName',
        'firstName',
        'email',
        'mobile',
        'adress',
        'status'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'id'); 
    }

}
