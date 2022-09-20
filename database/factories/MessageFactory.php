<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $isReaded = fake()->boolean();

        return [
            'content' => fake()->words(5, true),
            'is_readed' => $isReaded,
            'read_at' => $isReaded ? fake()->dateTimeThisMonth() : null,
        ];
    }

    public function setSenderAndReceiver($sender_id, $receiver_id)
    {
        return $this->state(fn (array $attributes) => [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id
        ]);
    }
}
