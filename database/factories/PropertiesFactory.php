<?php

namespace Database\Factories;

use App\Models\Properties;
use App\Models\User;  // Assurer que 'owner_id' et 'manager_id' sont des utilisateurs existants
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertiesFactory extends Factory
{
    protected $model = Properties::class;

    public function definition(): array
    {
        return [
            'manager_id' => 4, // Associer à un utilisateur existant pour manager
            'name' => $this->faker->company, // Nom de l'immeuble
            'address' => $this->faker->address, // Adresse
            'city' => $this->faker->city, // Ville
            'zip_code' => $this->faker->postcode, // Code postal
            'latitude' => 0, // Latitude
            'longitude' => 0, // Longitude
            'max_units' => $this->faker->numberBetween(1, 50), // Nombre maximal d'unités
            'status' => $this->faker->randomElement(['actif']), // Statut de la propriété
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
