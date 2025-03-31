<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\Lease;
use App\Models\LegalDocument;
use App\Models\Maintenance;
use App\Models\Payment;
use App\Models\Properties;
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
            'password' => Hash::make('test'),
            'role' => 'admin',
        ]);

        $regie = User::create([
            'name' => 'Gestionnaire Immo',
            'email' => 'regie@example.com',
            'password' => Hash::make('test'),
            'role' => 'user',
        ]);

        $technician = User::create([
            'name' => 'Jean Dupont',
            'email' => 'tech@example.com',
            'password' => Hash::make('test'),
            'role' => 'user',
        ]);

        $tenant = User::create([
            'name' => 'Alice Locataire',
            'email' => 'admin@test.com',
            'password' => Hash::make('test'),
            'role' => 'manager',
        ]);


        $properties = Properties::create([
            'manager_id' => $tenant->id,
            'name' => 'Propriété 1',
            'address' => 'Rue du Grütli 2',
            'city' => 'Genève',
            'zip_code' => '1204',
            'latitude' => 46.203455,
            'max_units' => 10,
            'longitude' => 6.141271,
            'status' => 'actif',
            'type' => 'locatif',
        ]);

        Unit::create([
            'property_id' => $properties->id,
            'tenant_id' => null,
            'type' => 'appartement',
            'area' => 45.00,
            'status' => 'libre',
            'initial_rent_price' => 500.00,
            'floor' => '0',
            'name' => 'Appartement 1',
        ]);

        // Properties::factory(1)->create()->each(function ($property) {
        //     $units = Unit::factory(5)->create(['property_id' => $property->id]);
        //     $units->each(function ($unit) {
        //         Tenant::factory(2)->create();
        //     });
        // });

        $company = Company::create([
            'name' => 'Entreprise A',
            'email' => 'raphael.moryson@gmail.com',
            'phone' => '07 67 36 66 27',
            'address' => '1 chemin du moulin',
            'city' => 'Genève',
            'zip_code' => '1204',
            'siren' => '123456789',
        ]);


        // $invoiceId = Invoice::create([
        //     'tenant_id' => 1,
        //     'unit_id' => 1,
        //     'amount' => 1200.00,
        //     'qr_code' => null,
        //     'due_date' => Carbon::now()->addMonth()->endOfMonth(),
        //     'status' => 'en attente',
        //     'name' => 'Loyer',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // InvoiceLine::create([
        //     'invoice_id' => 1,
        //     'description' => 'Loyer du mois',
        //     'quantity' => 1,
        //     'unit_price' => 1200.00,
        //     'total' => 1200.00,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);


        Tenant::create([
            'firstName' => 'Alice',
            'lastName' => 'Dutest',
            'email' => 'raphael.moryson@gmail.com',
            'mobile' => '07 67 36 66 27',
            'adress' => '1 chemin du moulin',
            'status' => 'actif',
        ]);

    }
}
