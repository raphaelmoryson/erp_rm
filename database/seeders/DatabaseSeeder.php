<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Lease;
use App\Models\LegalDocument;
use App\Models\Maintenance;
use App\Models\Payment;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\Unit;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        // Créer des utilisateurs : propriétaires, régies, techniciens, locataires
        $owner = User::create([
            'name' => 'Propriétaire SA',
            'email' => 'owner@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $regie = User::create([
            'name' => 'Gestionnaire Immo',
            'email' => 'regie@example.com',
            'password' => Hash::make('123'),
            'role' => 'user',
        ]);

        $technician = User::create([
            'name' => 'Jean Dupont',
            'email' => 'tech@example.com',
            'password' => Hash::make('123'),
            'role' => 'user',
        ]);

        $tenant = User::create([
            'name' => 'Alice Locataire',
            'email' => 'admin@test.com',
            'password' => Hash::make('123'),
            'role' => 'admin',
        ]);

        // Créer un immeuble
        $property = Property::create([
            'manager_id' => $owner->id,
            'name' => 'Immeuble Quai du Mont-Blanc',
            'address' => '15 Quai du Mont-Blanc',
            'latitude' => 46.24523402618571,
            'longitude' =>  6.199683967732264,
            'city' => 'Genève',
            'zip_code' => '1201',
            'max_units' => 5,
            'status' => 'actif',
            'type' => 'proprietaire',
        ]);


        $tenant = Tenant::create([
            'lastName'=> 'Krabi ',
            'firstName'=> 'Mohamed',
            'email' => 'raphael.moryson@gmail.com',
            'mobile' => '0767366627',
            'adress' => '',
            'status' => 'actif',
        ]);
            
        // Créer un lot (appartement) dans l’immeuble
        $unit = Unit::create([
            'property_id' => $property->id,
            'tenant_id' => $tenant->id,
            'name' => 'Appartement citadelle',
            'type' => 'appartement',
            'floor' => 'étage 1',   
            'area' => 75.5,
            'status' => 'loué',
        ]);
 

        // Créer un contrat de location
        $lease = Lease::create([
            'unit_id' => $unit->id,
            'tenant_id' => $tenant->id,
            'start_date' => Carbon::now()->subMonths(6),
            'end_date' => Carbon::now()->addYear(1),
            'deposit_amount' => 2500.00,
            'status' => 'actif',
        ]);

        // Créer une facture
        $invoice = Invoice::create([
            'lease_id' => $lease->id,
            'amount' => 1800.00,
            'qr_code' => 'QR123456789', // Simulons un QR code fictif
            'due_date' => Carbon::now()->addDays(10),
            'status' => 'en attente',
        ]);

 
        // Créer une intervention technique
        Maintenance::create([
            'unit_id' => $unit->id,
            'technician_id' => $technician->id,
            'issue' => 'Fuite d’eau dans la salle de bain',
            'status' => 'en cours',
        ]);

        // Créer un document juridique (bail)
        LegalDocument::create([
            'lease_id' => $lease->id,
            'type' => 'bail',
            'file_path' => 'storage/bails/bail_123.pdf',
        ]);


    }
}
