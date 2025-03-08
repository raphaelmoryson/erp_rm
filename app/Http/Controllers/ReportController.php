<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Property;
use App\Models\Unit;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestQuoteMail;

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
            'unit_id' =>   $request->unit_id ?? null,
            'company_id' => $request->company_id,
            'description' => $request->description,
            'photo' => $photoPath,
            'status' => 'pending',
        ]);

        $company = Company::findOrFail($request->company_id);
        $property = Property::findOrFail(1);
        $unit = Unit::find($request->unit_id);
        // $quoteLink = route('quote.submit', ['company' => $company->id, 'code' => encrypt($company->id . now())]);
        $quoteLink = "test";
        Mail::to($company->email)->send(new RequestQuoteMail($company, $property, $unit, $request->description, $photoPath, $quoteLink));

        return redirect()->back()->with('success', 'Le problème a été signalé avec succès. Un email a été envoyé à l\'entreprise.');
    }
}
