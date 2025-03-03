<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalFile extends Model
{
    protected $fillable = ['technical_folder_id', 'file_name', 'file_path'];

    public function folder()
    {
        return $this->belongsTo(TechnicalFolder::class, 'technical_folder_id');
    }
}
