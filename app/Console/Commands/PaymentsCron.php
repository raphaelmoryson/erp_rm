<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PaymentsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Log::info('Cron job started');

        $tenants = Tenant::where('status', 'actif')->with('unit')->get(); // Charge la relation 'unit'

        foreach ($tenants as $tenant) {
            if (!is_null($tenant->unit)) { // Vérifie que le locataire a bien un appart attribué
                Payment::firstOrCreate(
                    [
                        'tenant_id' => $tenant->id,
                        'unit_id' => $tenant->unit->id,
                        'due_date' => Carbon::now()->endOfMonth(),
                    ],
                    [
                        'amount' => $tenant->unit->initial_rent_price, // 💰 Montant du loyer
                        'status' => 'en attente',
                    ]
                );
            }
        }
        \Log::info('Cron job completed');
    }

}
