<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    public function index()
    {
        $properties = Property::all();
        return view('page.properties.properties', ['properties' => $properties]);
    }

    public function create()
    {
        return view('page.properties.create-properties');
    }
}
