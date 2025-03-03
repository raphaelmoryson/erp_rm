<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Tenant;
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

            $properties = Property::create([
                'manager_id' => $request->manager,
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
                'zip_code' => $request->postal_code,
                'status' => $request->status,
                'type' => $request->type,
                'latitude' => $lat,
                'longitude' => $long,
                'max_units' => $request->max_units,
            ]);

            return redirect("/properties/");
        }
    }

    public function show($id)
    {
        $building = Property::where("id", $id)->first();
        $units = Unit::where('property_id', $id)->with('tenant')->get();
        $occupancyRate = (count($units) / $building->max_units) * 100;
        // return $building;
        return view('page.properties.edit-properties', ['units' => $units, 'building' => $building, 'occupancyRate' => $occupancyRate]);
    }
    public function tenants_add($id)
    {
        $building = Property::where("id", $id)->first();
        $tenants = Tenant::all();
        return view('page.properties.units.add', ['building' => $building, 'tenants' => $tenants]);
    }

    public function tenants_post(Request $request, int $id)
    {
        if ($request->tenant_id == "0") {
            $request->tenant_id == null;
        }
        Unit::create([
            'property_id' => $id,
            'tenant_id' => $request->tenant_id,
            'type' => $request->type,
            'area' => $request->area,
            'status' => $request->status,
            'floor' => $request->floor,
            'name' => $request->name,
        ]);
        return redirect('/properties/edit/' . $id)->with('success', 'Appartement créer avec succès');
    }
    public function units_delete(int $id)
    {
        $info = Unit::findOrFail($id);
        $del = Unit::findOrFail($id)->delete();
        return redirect('/properties/edit/' . $info->property_id)->with('success', 'Appartement supprimer avec succès');

    }

    public function show_units(Request $request, int $id) {
        $units = Unit::where("id", $id)->first();
        return view('page.properties.units.show', ["units"=> $units]);
    }
}
