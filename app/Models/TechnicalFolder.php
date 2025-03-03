<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalFolder extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'property_id'];

    public function files()
    {
        return $this->hasMany(TechnicalFile::class);
    }
}
