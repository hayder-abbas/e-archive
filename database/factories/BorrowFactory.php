<?php

namespace Database\Factories;

use App\Models\Borrow;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Borrow>
 */
class BorrowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lender' => fake()->firstName(),
            'borrower' => fake()->firstName(),
            'number' => fake()->buildingNumber(),
            'date' => fake()->date(),
        ];
    }
}
