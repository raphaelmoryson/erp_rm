<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function assignTenant(Request $request, $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->tenant_id = $request->tenant_id;
        $unit->save();

        return back()->with('success', 'Locataire attribué avec succès !');
    }

    public function removeTenant($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->tenant_id = null;
        $unit->save();

        return back()->with('success', 'Locataire désattribué avec succès !');
    }

}
