<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Property;
use App\Models\Unit;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function store(Request $request)
    {
   
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('reports', 'public');
        }

        $report = Report::create([
            'property_id' => 1,
            'unit_id' => $request->unit_id,
            'company_id' => $request->company_id,
            'description' => $request->description,
            'photo' => $photoPath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Le problème a été signalé avec succès.');
    }
}
