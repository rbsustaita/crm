<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
        /**
     * The current password being used by the factory.
     */
    protected static ?string $password;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'trade_name' => fake()->companySuffix('S.A. de C.V.'),
            'tax_id' => fake()->unique()->numerify('###'),
            'address_id' => 1,
            'industry' => fake()->word(),
            'website' => fake()->url(),
            'active' => fake()->boolean(),
            'person_id' => 1,
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

/*     public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'active' => null,
        ]);
    } */
}
