<?php

namespace Database\Seeders;

use App\Models\Invoice;
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
            'role' => 'manager',
        ]);

   
        Properties::factory(1)->create()->each(function ($property) {
            $units = Unit::factory(5)->create(['property_id' => $property->id]);
            $units->each(function ($unit) {
                Tenant::factory(2)->create();
            });
        });
        
        
   
    }
}
