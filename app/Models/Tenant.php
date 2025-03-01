<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    // Définir les champs mass assignables
    protected $fillable = [
        'lastName',
        'firstName',
        'email',
        'mobile',
        'adress',
        'status'
    ];
}
