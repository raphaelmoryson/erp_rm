<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use TCPDF;
use Illuminate\Support\Facades\View;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $pdf = $this->generatePDF();

        return $this->from('facturation@tonsite.com')
            ->subject('Votre facture du mois')
            ->view('emails.invoice', ['invoice' => $this->invoice])
            ->attachData($pdf, 'facture-' . $this->invoice->id . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }

    /**
     * Générer le PDF avec TCPDF en utilisant la vue existante.
     */
    private function generatePDF()
    {
        $invoice = Invoice::with('tenant', 'unit', 'invoiceLines')->findOrFail($this->invoice->id);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Company');
        $pdf->SetTitle('Facture #' . $invoice->id);
        $pdf->SetSubject('Facture');
        
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        
        $pdf->AddPage();
        
        // Charger l'image du logo
        $logoPath = public_path('images/logo2.png'); // Vérifie que ce chemin est correct
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 10, 15, 25); // Ajoute l'image du logo en haut à gauche
        }
        
        $pdf->SetFont('helvetica', '', 12);
        
        // Générer le HTML pour le PDF
        $html = View::make('Page.Invoice.pdf', ['invoice' => $invoice])->render();
        $pdf->writeHTML($html, true, false, true, false, '');
        
        return $pdf->Output('', 'S');
    }
}
