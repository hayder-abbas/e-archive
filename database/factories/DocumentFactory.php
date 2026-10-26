<?php

namespace Database\Factories;

use App\Models\Box;
use App\Models\Document;
use App\Models\Entity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => fake()->buildingNumber(),
            'date' => fake()->date(),
            'subject' => fake()->word(),
            'type' => fake()->randomElement(['Incoming', 'Outgoing']),
            'security' => fake()->randomElement(['Normal', 'Secure']),
            'belongs_to' => fake()->buildingNumber(),
            'notes' => fake()->paragraph(2),
            'box_id' => Box::factory(),
            'entity_id' => Entity::factory(),
        ];
    }
}
