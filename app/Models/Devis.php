<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'description', 'photo', 'linkUrl', 'status'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
