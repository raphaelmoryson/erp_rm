<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Property;
use App\Models\Unit;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestQuoteMail;
use Illuminate\Support\Str;
class ReportController extends Controller
{
    public function store(Request $request)
    {

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('reports', 'public');
        }
        $random = Str::random(25);

        $report = Report::create([
            'property_id' => 1,
            'unit_id' => $request->unit_id ?? null,
            'company_id' => $request->company_id,
            'description' => $request->description,
            'linkUrl' => $random,
            'photo' => $photoPath,
            'status' => 'pending',
        ]);

        $company = Company::findOrFail($request->company_id);
        $property = Properties::findOrFail(1);
        $unit = Unit::find($request->unit_id);
        $quoteLink = url('/report/' . $random);
        Mail::to($company->email)->send(new RequestQuoteMail($company, $property, $unit, $request->description, $photoPath, $quoteLink));

        return redirect()->back()->with('success', 'Le problème a été signalé avec succès. Un email a été envoyé à l\'entreprise.');
    }

    public function report_postfile($slug)
    {
        $report = Report::where('linkUrl', $slug)->with('property', 'unit', 'company')->first();
        return view('page.report.show', ['report'=> $report]);
        // return $report;
    }
}
