<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Models\ReportLine;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Unit;
use App\Models\Company;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequestQuoteMail;
use Illuminate\Support\Str;
use TCPDF;
use View;
class ReportController extends Controller
{
    public function store(Request $request)
    {
        $photo = $request->file('photo');
        if ($photo) {
            $photoPath = $photo->store('reports', 'public');
        } else {
            $photoPath = null;
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

        ReportLine::create([
            'report_id' => $report->id,
            'type' => 'progress',
            'detail' => "Problème signalé par {$report->unit->tenant->firstName} {$report->unit->tenant->lastName} à l'entreprise {$report->company->name}.",
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
            return view('page.report.report', ['report' => $report, 'slug' => $slug]);
        } else {
            return abort(404);
        }
        // return $report;
    }


    public function post_accepted(Request $request, $slug)
    {
        $file = $request->file('fileQuote');
        $path = $file->store('reports_file', 'public');

        $report = Report::where('linkUrl', $slug)->firstOrFail();
        $report->update([
            'linkUrl' => null,
            'status' => 'in_progress',
        ]);

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
    }

    public function post_refused(Request $request, $slug)
    {
        $report = Report::where('linkUrl', $slug)->firstOrFail();
        $report->update([
            'linkUrl' => null,
            'status' => 'refused',
        ]);

        ReportLine::create([
            'report_id' => $report->id,
            'type' => 'progress',
            'detail' => "L'entreprise a réfusé l'intervention.",
        ]);

    }
    public function show($id)
    {
        $report = Report::with('company', 'property', 'unit', 'reportLines')->findOrFail($id);
        return view('page.report.show', compact('report'));
        // return $report;
    }

    public function toggleStatus($id, Request $request)
    {
        $report = Report::findOrFail($id);

        $report->status = $request->status;
        $report->save();

        return redirect()->back()->with('success', 'Statut mis à jour avec succès.');
    }

    public function status($id, Request $request)
    {
        $report = Report::findOrFail($id);

        $report->status = $request->status;
        $report->save();

        return redirect()->back()->with('success', 'Statut mis à jour avec succès.');
    }

    public function createWorkOrder($id)
    {
        ReportLine::create([
            'report_id' => $id,
            'type' => 'work_order',
            'file_path' => url('/reports/' . $id . '/work-order'),
            'detail' => "Bon de travaux créé en attente d'envoie.",
        ]);

        return redirect()->back()->with('success', 'Bon de travaux créé avec succès.');

    }

    public function workOrder($id, Request $request)
    {
        $report = Report::with('company', 'property', 'unit')->findOrFail($id);

        $html = View::make('pdf.work_order', compact('report'))->render();

        $pdf = new TCPDF();
        $pdf->SetCreator('Laravel');
        $pdf->SetAuthor($report->company->name);
        $pdf->SetTitle('Bon de Travaux');
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 10);

        $pdf->writeHTML($html, true, false, true, false, '');

        return response()->streamDownload(function () use ($pdf) {
            $pdf->Output('bon_de_travaux.pdf', 'I');
        }, 'bon_de_travaux.pdf');


    }

}
