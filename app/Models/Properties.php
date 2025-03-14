<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    use HasFactory;

    protected $table = "properties";
    protected $fillable = [
        'manager_id',
        'name',
        'address',
        'city',
        'zip_code',
        'latitude',
        'max_units',
        'longitude',
        'status',
    ];


    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
