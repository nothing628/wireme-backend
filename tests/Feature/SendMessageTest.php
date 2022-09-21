<?php

use App\Models\User;
use Database\Seeders\UserSeeder;
use Database\Seeders\ChatSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function \Pest\Laravel\actingAs;
use function \Pest\Laravel\postJson;
use function \Pest\Laravel\seed;

uses(RefreshDatabase::class);

beforeEach(function () {
    seed(UserSeeder::class);
    seed(ChatSeeder::class);
});

test('send message with unauthorized user', function () {
    $testingUser = User::where('email', 'test@example.com')->first();
    $testingChat = $testingUser->chats->first();

    $response = postJson("/api/chats/$testingChat->id/messages", [
        'content' => fake()->words(5, true)
    ]);
    $response->assertStatus(401);
});
