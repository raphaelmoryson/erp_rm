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

class QrBillController extends Controller
{
    public function generateQrBill()
    {
        // Créer la facture QR
        $qrBill = QrBill::create();

        // Ajouter le créancier
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

        // Vérifier et créer le dossier s'il n'existe pas
        if (!file_exists(public_path('qr_codes'))) {
            mkdir(public_path('qr_codes'), 0777, true);
        }

        try {
            // Générer et sauvegarder le QR Code en PNG et SVG
            $qrBill->getQrCode()->writeFile($pngPath);
            $qrBill->getQrCode()->writeFile($svgPath);

            return response()->json([
                'message' => 'QR Code généré avec succès !',
                'png_url' => asset('qr_codes/qr.png'),
                'svg_url' => asset('qr_codes/qr.svg')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la génération du QR Code : ' . $e->getMessage()
            ], 500);
        }
    }
}
