<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Models\ReportLine;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Property;
use App\Models\Unit;
use File;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestQuoteMail;
use Illuminate\Support\Str;
class ReportController extends Controller
{
    public function store(Request $request)
    {
        $photo = $request->file('photo');
        $photoPath = $photo->store('reports', 'public');

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

        Mail::to($company->email)->send(new RequestQuoteMail(
            $company,
            $property,
            $unit,
            $request->description,
            $quoteLink
        ));


        return redirect()->back()->with('success', 'Le problème a été signalé avec succès. Un email a été envoyé à l\'entreprise.');
    }

    public function report_postfile($slug)
    {
        $report = Report::where('linkUrl', $slug)->with('property', 'unit', 'company')->first();
        if ($report) {
            return view('page.report.report', ['report' => $report]);
        } else {
            return abort(404);
        }
        // return $report;
    }


    public function post(Request $request, $slug)
    {
        $file = $request->file('fileQuote');
        $path = $file->store('reports_file', 'public');
    
        $report = Report::where('linkUrl', $slug)->firstOrFail();
        $report->update([
            'linkUrl' => null,
            'status' => 'in_progress',
        ]);
    
        // Création de la ligne d'historique avec message d'acceptation
        ReportLine::create([
            'report_id' => $report->id,
            'type' => 'progress',
            'detail' => "Acceptation de l'intervention par l'entreprise {$report->company->name} et devis déposé.",
        ]);
    
        ReportLine::create([
            'report_id' => $report->id,
            'type' => 'document',
            'file_path' => $path,
        ]);
    
        return redirect("/")->with('success', 'Intervention acceptée et devis déposé.');
    }

    public function show($id)
    {
        $report = Report::with('company', 'property', 'unit','reportLines')->findOrFail($id);
        return view('page.report.show', compact('report'));
        // return $report;
    }
}
