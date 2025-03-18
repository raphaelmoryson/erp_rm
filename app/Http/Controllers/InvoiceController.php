<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use TCPDF;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('tenant', 'unit')->get();
        return view('page.invoice.show', ['invoices' => $invoices]);
    }
    public function showPdf($id)
    {
        $invoice = Invoice::with('tenant', 'unit', 'invoiceLines')->findOrFail($id);

        $pdf = new TCPDF();

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Company');
        $pdf->SetTitle('Facture #' . $invoice->id);
        $pdf->SetSubject('Facture');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        $pdf->SetFont('helvetica', '', 12);

        $html = view('page.invoice.pdf', ['invoice' => $invoice])->render();

        $pdf->writeHTML($html, true, false, true, false, '');

        // Output the PDF
        return response($pdf->Output('facture-' . $invoice->id . '.pdf', 'I'))->header('Content-Type', 'application/pdf');
    }
}
