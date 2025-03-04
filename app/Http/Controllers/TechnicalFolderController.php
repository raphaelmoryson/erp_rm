<?php

namespace App\Http\Controllers;

use App\Models\TechnicalFolder;
use Illuminate\Http\Request;

class TechnicalFolderController extends Controller
{
    public function store(Request $request, $buildingId)
    {
        $request->validate(['name' => 'required|string|max:255']);
    
        TechnicalFolder::create([
            'name' => $request->name,
            'property_id' => $buildingId
        ]);
    
        return back()->with('success', 'Dossier créé avec succès.');
    }
    public function destroy(Request $request, $buildingId) {
        $get = TechnicalFolder::where('id', $buildingId)->with('files')->first();
        $get->delete();
        return back()->with('success','Dossier supprimé avec succès');

        
    }
}
