<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Les commandes artisan disponibles pour l'application.
     *
     * @var array
     */
    protected $commands = [
        // Ajoute ici tes commandes personnalisées
        Commands\PaymentsCron::class,
    ];

    /**
     * Définir la planification des commandes Artisan.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Planifier tes tâches cron ici
        $schedule->command('test:cron')->everyMinute(); // Exemple
        
    }

    /**
     * Configure l'application pour exécuter les commandes artisan.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
