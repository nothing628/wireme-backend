<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat>
 */
class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'is_archived' => fake()->boolean(),
            'last_message' => fake()->words(3, true),
            'last_seen_at' => fake()->dateTimeThisMonth(),
        ];
    }

    /**
     * Create archived chat model
     *
     * @return static
     */
    public function archived()
    {
        return $this->state(fn (array $attributes) => [
            'is_archived' => true
        ]);
    }

    /**
     * Create active chat model
     *
     * @return static
     */
    public function notArchived()
    {
        return $this->state(fn (array $attributes) => [
            'is_archived' => false
        ]);
    }
}
