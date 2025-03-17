<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Models\Tenant;
use App\Models\Unit;
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
        $units = Unit::where('status', 'loué')->get();
        \Log::info('Nombre d\'unités trouvées : ' . $units->count());

        foreach ($units as $unit) {
            try {
                Payment::create([
                    'tenant_id' => $unit->tenant_id,
                    'unit_id' => $unit->id,
                    'due_date' => Carbon::now()->endOfMonth(),
                    'amount' => $unit->initial_rent_price,
                    'status' => 'en attente',
                ]);
                \Log::info('Paiement créé pour le locataire ID : ' . $unit->tenant_id);
            } catch (\Exception $e) {
                \Log::error('Erreur lors de la création du paiement : ' . $e->getMessage());
            }
        }
        

        \Log::info('Cron job completed');
    }

}
