<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Sprain\SwissQrBill\QrBill;
use Sprain\SwissQrBill\DataGroup\Element\StructuredAddress;
use Sprain\SwissQrBill\DataGroup\Element\CreditorInformation;
use Sprain\SwissQrBill\DataGroup\Element\PaymentAmountInformation;
use Sprain\SwissQrBill\DataGroup\Element\PaymentReference;
use Sprain\SwissQrBill\DataGroup\Element\AdditionalInformation;
use Sprain\SwissQrBill\Reference\QrPaymentReferenceGenerator;
use TCPDF;
use Sprain\SwissQrBill\PaymentPart\Output\TcPdfOutput\TcPdfOutput;
use Sprain\SwissQrBill\PaymentPart\Output\DisplayOptions;

class QrBillController extends Controller
{
    public function generateQrBill()
    {
        $qrBill = QrBill::create();

        $qrBill->setCreditor(
            StructuredAddress::createWithStreet(
                'Robert Schneider AG',
                'Rue du Lac',
                '1268',
                '2501',
                'Biel',
                'CH'
            )
        );

        // Ajouter l'IBAN du créancier (QR-IBAN obligatoire)
        $qrBill->setCreditorInformation(
            CreditorInformation::create('CH4431999123000889012')
        );

        // Ajouter le débiteur
        $qrBill->setUltimateDebtor(
            StructuredAddress::createWithStreet(
                'Pia-Maria Rutschmann-Schnyder',
                'Grosse Marktgasse',
                '28',
                '9400',
                'Rorschach',
                'CH'
            )
        );

        // Ajouter le montant et la devise
        $qrBill->setPaymentAmountInformation(
            PaymentAmountInformation::create('CHF', 2500.25)
        );

        // Générer la référence de paiement
        $referenceNumber = QrPaymentReferenceGenerator::generate(
            '210000',  // BESR-ID fourni par la banque (NULL pour PostFinance)
            '313947143000901' // Numéro de facture ou identifiant interne
        );

        $qrBill->setPaymentReference(
            PaymentReference::create(
                PaymentReference::TYPE_QR,
                $referenceNumber
            )
        );

        // Ajouter des informations supplémentaires
        $qrBill->setAdditionalInformation(
            AdditionalInformation::create('Invoice 123456, Gardening work')
        );

        // Définir le chemin de sauvegarde
        $pngPath = public_path('qr_codes/qr.png');
        $svgPath = public_path('qr_codes/qr.svg');
        $pdfPath = public_path('qr_codes/swiss_qr_bill.pdf');

        if (!file_exists(public_path('qr_codes'))) {
            mkdir(public_path('qr_codes'), 0777, true);
        }

        try {
            $qrBill->getQrCode()->writeFile($pngPath);
            $qrBill->getQrCode()->writeFile($svgPath);

            // **Générer et sauvegarder la facture Swiss QR en PDF avec TCPDF**
            $tcpdf = new TCPDF('P', 'mm', 'A4', true, 'ISO-8859-1');
            $tcpdf->setPrintHeader(false);
            $tcpdf->setPrintFooter(false);
            $tcpdf->AddPage();

            // Création de l'output TCPDF
            $output = new TcPdfOutput($qrBill, 'fr', $tcpdf);

            // Options d'affichage pour la mise en page
            $displayOptions = new DisplayOptions();
            $displayOptions
                ->setPrintable(false) // Afficher les lignes de découpe pour impression
                ->setDisplayTextDownArrows(false) // Cacher les flèches
                ->setDisplayScissors(true) // Afficher les ciseaux pour la découpe
                ->setPositionScissorsAtBottom(false); // Ciseaux en haut

            // Génération de la partie paiement dans le PDF
            $output
                ->setDisplayOptions($displayOptions)
                ->getPaymentPart();

            // Sauvegarde du fichier PDF
            $tcpdf->Output($pdfPath, 'F');

            return response()->json([
                'message' => 'Swiss QR Bill générée avec succès !',
                'png_url' => asset('qr_codes/qr.png'),
                'svg_url' => asset('qr_codes/qr.svg'),
                'pdf_url' => asset('qr_codes/swiss_qr_bill.pdf')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la génération de la Swiss QR Bill : ' . $e->getMessage()
            ], 500);
        }
    }
}
