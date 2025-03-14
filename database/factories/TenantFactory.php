<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tenant;
use App\Models\Unit;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'lastName' => $this->faker->lastName, // Nom de famille
            'firstName' => $this->faker->firstName, // Prénom
            'email' => $this->faker->safeEmail, // Email valide
            'mobile' => $this->faker->phoneNumber, // Numéro de téléphone
            'adress' => $this->faker->address, // Adresse
            'status' => $this->faker->randomElement(['actif']), // Statut aléatoire
        ];
    }
}
