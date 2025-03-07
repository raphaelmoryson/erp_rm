<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
class PaymentController extends Controller
{
 
    // Enregistrer un paiement
    public function store(Request $request)
    {
        $request->validate([
            'tenant_id' => 'required|exists:tenants,id',
            'unit_id' => 'required|exists:units,id',
            'amount' => 'required|numeric|min:0',
            'due_date' => 'required|date',
            'payment_method' => 'required|string',
        ]);

        Payment::create($request->all());

        return redirect()->back()->with('success', 'Paiement enregistré avec succès.');
    }

    // Marquer comme payé
    public function markAsPaid($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update([
            'status' => 'payé',
            'paid_at' => now()
        ]);

    }
}
