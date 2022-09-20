<?php

use App\Models\User;
use Database\Seeders\UserSeeder;
use Database\Seeders\ChatSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function \Pest\Laravel\actingAs;
use function \Pest\Laravel\getJson;
use function \Pest\Laravel\seed;

uses(RefreshDatabase::class);

beforeEach(function () {
    seed(UserSeeder::class);
    seed(ChatSeeder::class);
});

test('list chat with unauthorized user', function () {
    $response = getJson('/api/chats');
    $response->assertStatus(401);
});


test('correct list chat action', function () {
    $testingUser = User::where('email', 'test@example.com')->first();
    $testingChats = $testingUser->chats;
    $firstChat = $testingChats->first();

    actingAs($testingUser);

    $response = getJson('/api/chats');
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'chats' => [
            '*' => [
                'id',
                'is_archived',
                'last_message',
                'last_seen_at',
                'created_at',
                'updated_at',
            ]
        ]
    ]);
    $response->assertJsonCount($testingChats->count(), 'chats');
    expect($response->json('chats.0'))->toMatchArray([
        'id' => $firstChat->id,
        'is_archived' => $firstChat->is_archived,
        'last_message' => $firstChat->last_message,
        'last_seen_at' => $firstChat->last_seen_at->toJson(),
        'created_at' => $firstChat->created_at->toJson(),
        'updated_at' => $firstChat->updated_at->toJson(),
    ]);
});
