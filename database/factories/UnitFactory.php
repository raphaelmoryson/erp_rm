<?php

namespace Database\Factories;

use App\Models\Properties;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Unit;
use App\Models\Property;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        return [
            'property_id' => Properties::factory(), // Associe à un immeuble existant
            'tenant_id' => Tenant::factory(), // Associe à un immeuble existant
            'name' => $this->faker->name,
            'area' => $this->faker->randomFloat(2, 10, 5000),
            'floor' => $this->faker->numberBetween(1, 10),
            'initial_rent_price' => $this->faker->randomFloat(2, 500, 5000), // Prix du loyer
            'status' => $this->faker->randomElement(['loué']),
            'type' => $this->faker->randomElement(['appartement', 'bureau', 'commerce']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
