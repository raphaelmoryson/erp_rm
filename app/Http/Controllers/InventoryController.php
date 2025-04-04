<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryDetails;
use App\Models\Tenant;
use Illuminate\Http\Request;
use TCPDF;

class InventoryController extends Controller
{

    public function store(Request $request)
    {

        $etat = Inventory::create($request->all());

        foreach ($request->elements as $element) {
            InventoryDetails::create([
                'inventory_id' => $etat->id,
                'element' => $element['name'],
                'etat' => $element['etat'],
                'remarques' => $element['remarques'] ?? null,
                'photo' => $element['photo'] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'État des lieux ajouté');
    }
    public function generatePDF($id)
    {
        $inventory = Inventory::with('unit.tenant', 'elements')->findOrFail($id);

        $html = view('Page.Inventory.pdf', compact('inventory'))->render();

        $pdf = new TCPDF();

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Ton Entreprise');
        $pdf->SetTitle('État des Lieux');
        $pdf->SetSubject('État des Lieux - ' . $inventory->unit->name);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->AddPage();

        $pdf->SetFont('helvetica', '', 12);

        $pdf->writeHTML($html, true, false, true, false, '');

        return response($pdf->Output('etat_des_lieux_' . $id . '.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }

}
