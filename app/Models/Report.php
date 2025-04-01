<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'unit_id',
        'company_id',
        'description',
        'work_order',
        'linkUrl',
        'photo',
        'status',
    ];

    public function property()
    {
        return $this->belongsTo(Properties::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class, 'report_id', 'id'); // Correction ici
    }
    public function reportLines()
    {
        return $this->hasMany(ReportLine::class, 'report_id', 'id'); // Correction ici
    }
}

