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

test('send message to unauthorized chat', function () {
    $testingUser = User::where('email', 'test@example.com')->first();

    actingAs($testingUser);

    $response = postJson("/api/chats/000/messages", [
        'content' => fake()->words(5, true)
    ]);
    $response->assertStatus(400);
});

test('correct send message action', function () {
    $testingUser = User::where('email', 'test@example.com')->first();
    $testingChat = $testingUser->chats->first();
    $testingContent = fake()->words(5, true);

    actingAs($testingUser);

    $response = postJson("/api/chats/$testingChat->id/messages", [
        'content' => $testingContent
    ]);
    $response->assertOk();
    $response->assertJsonStructure([
        'message' => [
            'id',
            'chat_id',
            'sender_id',
            'content',
            'created_at',
        ]
    ]);

    $newMessage = $testingChat->messages()->where('content', $testingContent)->first();
    expect($newMessage)->not->toBeNull();
    expect($response->json('message'))->toMatchArray([
        'id' => $newMessage->id,
        'chat_id' => $testingChat->id,
        'sender_id' => $testingUser->id,
        'content' => $testingContent,
        'created_at' =>  $newMessage->created_at->toJson(),
    ]);
});
