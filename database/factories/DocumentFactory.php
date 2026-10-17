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
            'subject' => fake()->word(),
            'date' => fake()->date(),
            'file' => fake()->filePath(),
            'type' => fake()->randomElement(['Incoming', 'Outgoing']),
            'security' => fake()->randomElement(['Normal', 'Secure']),
            'notes' => fake()->paragraph(2),
            'box_id' => Box::factory(),
            'entity_id' => Entity::factory(),
        ];
    }
}
