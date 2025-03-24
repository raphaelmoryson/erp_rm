<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Http\Request;

class TenantsController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::with("unit");
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('firstName', 'LIKE', "%$search%")
                  ->orWhere('lastName', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%");
            });
        }
    
        $tenants = $query->paginate(10)->appends(['search' => $request->search]);
    
        return view('page.tenants.view', compact('tenants'));
    }
    

    public function create()
    {
        return view('page.tenants.create-tenants');
    }

    public function store(Request $request)
    {
        $request->validate([
            'lastName' => 'required|string|max:255',
            'firstName' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants',
            'mobile' => 'required|string|max:20',
            'adress' => 'required|string|max:255',
            'status' => 'required|in:actif,inactif,resilié',
        ]);

        Tenant::create($request->all());

        return redirect()->route('tenants')->with('success', 'Locataire ajouté avec succès !');
    }

    public function edit($id)
    {
        $tenant = Tenant::findOrFail($id);
        return view('page.tenants.edit-tenants', ['tenant' => $tenant]);
    }
    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'lastName' => 'required|string|max:255',
            'firstName' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email,' . $tenant->id,
            'mobile' => 'required|string|max:20',
            'adress' => 'required|string|max:255',
            'status' => 'required|in:actif,inactif,resilié',
        ]);

        $tenant->update($request->all());

        return redirect()->route('tenants.index')->with('success', 'Locataire mis à jour avec succès !');
    }

}
