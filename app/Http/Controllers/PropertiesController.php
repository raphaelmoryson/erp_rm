<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Unit;
use Carbon\Traits\Units;
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

    public function show($id) {
        $property = Property::find($id);
        $units = Unit::where('property_id', $property->id)->with('tenant')->get();
        // return $units;
        return view('page.properties.edit-properties', ['properties'=> $property, 'units' => $units]);
    }
}
