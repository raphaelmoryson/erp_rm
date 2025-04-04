<?php

namespace App\Http\Controllers;

use App\Mail\WorkOrderMail;
use App\Models\Properties;
use App\Models\ReportLine;
use App\Models\WorkOrder;
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
            'detail' => "Problème signalé par {$request->user()->name} à l'entreprise {$report->company->name}.",
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
            return view('Page.report.report', ['report' => $report, 'slug' => $slug]);
        } else {
            return abort(404);
        }
    }


    public function post_accepted(Request $request, $slug)
    {
        $file = $request->file('fileQuote');
        $path = $file->store('reports_file', 'public');

        $report = Report::where('linkUrl', $slug)->firstOrFail();
        $report->update([
            'linkUrl' => null,
            'status' => 'wa',
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
        $work_orders = false;
        foreach ($report->reportLines as $line) {
            if ($line->type === 'work_order') {
                $work_orders = true;
                break;
            }
        }
        return view('Page.report.show', compact('report', 'work_orders'));
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
        $report = Report::findOrFail($id);
        if (!$report) {
            return abort(404);
        }
        if ($report->work_order == true) {
            return redirect()->back()->with('error', 'Le bon de travaux a déjà été envoyé.');
        }
        return view('Page.Report.work-order', compact('id'));
    }

    public function storeWorkOrder(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        ReportLine::create([
            'report_id' => $report->id,
            'type' => 'work_order',
            'detail' => "Bon de travaux créé par {$request->user()->name}.",
            'file_path' => url("/reports/{$report->id}/work-order"),
        ]);

        WorkOrder::create([
            'report_id' => $report->id,
            'description' => $request->workReason,
            'status' => 'pending',
            'scheduled_date' => $request->scheduledDate,
            'execution_deadline' => $request->execution_deadline,
            'assigned_to' => $request->assignedTo,
            'quote_price' => $request->quotePrice,
            'comments' => "Devis reçu le : " . $request->quoteReceivedDate . " | Montant : " . $request->quotePrice . " CHF",
        ]);

        return redirect()->route('reports.show', $id)->with('success', 'Bon de travaux créé avec succès.');
    }

    public function sendWorkOrder($id, Request $request)
    {
        
        $report = Report::with('company', 'property', 'unit', 'workOrders')->findOrFail($id);
        if ($report->work_order == true) {
            return redirect()->back()->with('error', 'Le bon de travaux a déjà été envoyé.');
        }
        $report->update(['work_order' => true]);
        // PDF
        $html = View::make('pdf.work_order', compact('report'))->render();
        $pdf = new TCPDF();
        $pdf->SetCreator('Laravel');
        $pdf->SetAuthor($report->company->name);
        $pdf->SetTitle('Bon de Travaux');
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 10);
        $pdf->writeHTML($html, true, false, true, false, '');

        $fileName = 'bon_de_travaux_' . $report->id . '.pdf';
        $filePath = storage_path('app/public/' . $fileName);
        $pdf->Output($filePath, 'F');

        Mail::to($report->company->email)->send(new WorkOrderMail(
            $report->company,
            $report->property,
            $report->unit,
            $report->workOrders->first()->description ?? '',
            url("/reports/{$id}/work-order"),
            $filePath
        ));

        ReportLine::create([
            'report_id' => $report->id,
            'type' => 'progress',
            'detail' => "Bon de travaux envoyé à l'entreprise {$report->company->name}.",
        ]);

        return redirect()->back()->with('success', 'Bon de travaux envoyé avec succès.');
    }

    public function workOrder($id, Request $request)
    {
        $report = Report::with('company', 'property', 'unit', 'workOrders')->findOrFail($id);

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
