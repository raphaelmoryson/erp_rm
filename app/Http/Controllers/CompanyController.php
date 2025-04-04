<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index() {
        
        // Company::factory(10)->create();
        $company = Company::all();
        return view('Page.Company.index', ['companies'=> $company]);
    }
}
