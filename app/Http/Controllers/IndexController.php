<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Properties;
use App\Models\Report;
use App\Models\ReportLine;
use App\Models\Tenant;
use Illuminate\Http\Request;
use League\CommonMark\Extension\SmartPunct\Quote;

class IndexController extends Controller
{
    public function index()
    {
        $monthlyPayments = Payment::where('status', 'payé')
            ->selectRaw('SUM(amount) as total, EXTRACT(MONTH FROM created_at) as month')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $allPayments = [];
        for ($i = 1; $i <= 12; $i++) {
            $allPayments[] = $monthlyPayments[$i] ?? 0;
        }

        return view("welcome", [
            "numberProperties" => Properties::count(),
            "numberTenants" => Tenant::count(),
            "numberInterventions" => Report::where('status', 'in_progress')->count(),
            "numberQuotes" => 0,
            "latestActivities" => ReportLine::orderBy('created_at', 'desc')->where('type', 'progress')->take(5)->get(),
            "allPayments" => json_encode($allPayments), // JSON pour JS
        ]);



    }

}
