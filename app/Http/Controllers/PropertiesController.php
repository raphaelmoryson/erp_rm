<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Unit;
use App\Models\User;
use Carbon\Traits\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PropertiesController extends Controller
{
    public function index()
    {
        $properties = Property::all();
        return view('page.properties.properties', ['properties' => $properties]);
    }

    public function create()
    {
        $user = User::all()->where('role', 'manager');
        return view('page.properties.create-properties', ['managers' => $user]);
    }

    public function create_post(Request $request)
    {
        if ($request) {
            $fullAddress = $request->address . ', ' . $request->city . ', ' . $request->postal_code;

            $geoResponse = Http::withHeaders([
                'User-Agent' => 'MonApplication/1.0 (contact@monapp.com)' // Remplace par ton email/app
            ])->get('https://nominatim.openstreetmap.org/search', [
                        'format' => 'json',
                        'q' => $fullAddress,
                    ]);

            $latitude = null;
            $longitude = null;

            if ($geoResponse->successful() && !empty($geoResponse->json())) {
                $location = $geoResponse->json()[0];
                $latitude = (float) $location['lat']; // Conversion en décimal
                $longitude = (float) $location['lon']; // Conversion en décimal
            }

            $long = $longitude;
            $lat = $latitude;

            // Enregistrer la propriété avec les coordonnées
            $properties = Property::create([
                'manager_id' => $request->manager,
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
                'zip_code' => $request->postal_code,
                'status' => $request->status,
                'type' => $request->type,
                'latitude' => $lat,
                'longitude' => $long
            ]);


            return redirect("/properties/");
        }
    }

    public function show($id)
    {
        $building = Property::find($id);
        $units = Unit::where('property_id', $building->id)->with('tenant')->get();
        return view('page.properties.edit-properties', ['units' => $units, 'building' => $building]);
    }


}
