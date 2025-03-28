<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Payment;
use App\Models\Tenant;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;

class PaymentsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:generate_and_send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Génère les paiements et envoie les factures aux locataires';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Log::info('Début du cron de génération des paiements');
        $units = Unit::where('status', 'loué')->get();
        \Log::info('Nombre d\'unités trouvées : ' . $units->count());

        foreach ($units as $unit) {
            try {
                $invoice = Invoice::create([
                    'tenant_id' => $unit->tenant_id,
                    'unit_id' => $unit->id,
                    'due_date' => Carbon::now()->endOfMonth(),
                    'amount' => $unit->initial_rent_price,
                    'status' => 'en attente',
                ]);

                InvoiceLine::create([
                    'invoice_id' => $invoice->id,
                    'description' => 'Loyer pour le mois de ' . Carbon::now()->locale('fr')->translatedFormat('F Y'),
                    'quantity' => 1,
                    'unit_price' => $unit->initial_rent_price,
                    'total' => $unit->initial_rent_price,
                ]);

                Payment::create([
                    'invoice_id' => $invoice->id,
                    'tenant_id' => $unit->tenant_id,
                    'unit_id' => $unit->id,
                    'due_date' => Carbon::now()->endOfMonth(),
                    'amount' => $unit->initial_rent_price,
                    'status' => 'en attente',
                ]);

                \Log::info('Paiement et facture créés pour le locataire ID : ' . $unit->tenant_id);
            } catch (\Exception $e) {
                \Log::error('Erreur lors de la création du paiement ou de l\'envoi du mail : ' . $e->getMessage());
            }
        }

        \Log::info('Cron terminé avec succès');
    }
}
