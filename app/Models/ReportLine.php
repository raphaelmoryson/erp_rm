<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'type', // text, file, etc.
        'detail', // Texte descriptif de l'avancement
        'file_path', // Chemin du fichier s'il y en a un
    ];

    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id', 'id');
    }
}
