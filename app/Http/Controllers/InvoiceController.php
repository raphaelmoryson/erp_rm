<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use TCPDF;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('tenant', 'unit');
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%$search%")
                  ->orWhereHas('tenant', function ($q) use ($search) {
                      $q->where('lastName', 'LIKE', "%$search%")
                        ->orWhere('firstName', 'LIKE', "%$search%")
                        ->orWhere('amount', 'LIKE', "%$search%");
                  })
                  ->orWhere('amount', 'LIKE', "%$search%");
        }
    
        $invoices = $query->paginate(10)->appends(['search' => $request->search]);
    
        return view('page.invoice.show', compact('invoices'));
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

        return response($pdf->Output('facture-' . $invoice->id . '.pdf', 'I'))->header('Content-Type', 'application/pdf');
    }
}
