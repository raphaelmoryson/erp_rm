<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use TCPDF;
use Sprain\SwissQrBill\QrBill;
use Sprain\SwissQrBill\DataGroup\Element\StructuredAddress;
use Sprain\SwissQrBill\DataGroup\Element\CreditorInformation;
use Sprain\SwissQrBill\DataGroup\Element\PaymentAmountInformation;
use Sprain\SwissQrBill\DataGroup\Element\PaymentReference;
use Sprain\SwissQrBill\DataGroup\Element\AdditionalInformation;
use Sprain\SwissQrBill\Reference\QrPaymentReferenceGenerator;
use Sprain\SwissQrBill\PaymentPart\Output\TcPdfOutput\TcPdfOutput;
use Sprain\SwissQrBill\PaymentPart\Output\DisplayOptions;

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

        $qrBill = QrBill::create();
        $qrBill->setCreditor(
            StructuredAddress::createWithStreet(
                'Nom de votre entreprise',
                'Rue de l’Entreprise',
                '1',
                '1000',
                'Ville',
                'CH'
            )
        );

        // 🔹 Configuration des infos de paiement
        $qrBill->setCreditorInformation(CreditorInformation::create('CH4431999123000889012'));
        $qrBill->setUltimateDebtor(
            StructuredAddress::createWithStreet(
                $invoice->tenant->firstName . ' ' . $invoice->tenant->lastName,
                'Adresse du locataire',
                '123',
                '1000',
                'Ville',
                'CH'
            )
        );

        $qrBill->setPaymentAmountInformation(PaymentAmountInformation::create('CHF', $invoice->amount));
        $referenceNumber = QrPaymentReferenceGenerator::generate('210000', str_pad($invoice->id, 13, '0', STR_PAD_LEFT));
        $qrBill->setPaymentReference(PaymentReference::create(PaymentReference::TYPE_QR, $referenceNumber));
        $qrBill->setAdditionalInformation(AdditionalInformation::create('Facture #' . $invoice->id));

        $output = new TcPdfOutput($qrBill, 'fr', $pdf);
        $displayOptions = new DisplayOptions();
        $displayOptions->setPrintable(false)
            ->setDisplayTextDownArrows(false)
            ->setDisplayScissors(true)
            ->setPositionScissorsAtBottom(true);

        $output->setDisplayOptions($displayOptions)->getPaymentPart();

        return response($pdf->Output('facture-' . $invoice->id . '.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }

}
