<?php

use App\Models\Payment;
use App\Models\Tenant;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// Schedule::command('test:cron')->monthlyOn(1, '00:00'); 
// Schedule::command('test:cron')->monthlyOn(1, '00:00'); 
Schedule::command('test:cron')->everyMinute(); 