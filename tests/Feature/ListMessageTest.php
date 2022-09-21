<?php

use App\Models\User;
use App\Models\Chat;
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

test('list message with unauthorized user', function () {
    $testingUser = User::where('email', 'test@example.com')->first();
    $testingChat = $testingUser->chats->first();

    $response = getJson("/api/chats/$testingChat->id/messages");
    $response->assertStatus(401);
});

test('list message with unauthorized chat', function () {
    $testingUser = User::where('email', 'test@example.com')->first();

    actingAs($testingUser);

    $response = getJson("/api/chats/000/messages");
    $response->assertNotFound();
});


test('correct list message action', function () {
    $testingUser = User::where('email', 'test@example.com')->first();
    $testingChat = $testingUser->chats->first();

    actingAs($testingUser);

    $response = getJson("/api/chats/$testingChat->id/messages");
    $response->assertOk();
    $response->assertJsonStructure([
        'messages' => [
            "*" => [
                'id',
                'sender_id',
                'receiver_id',
                'content',
                'is_readed',
                'read_at'
            ]
        ]
    ]);
});
