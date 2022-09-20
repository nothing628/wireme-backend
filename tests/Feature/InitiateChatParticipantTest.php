<?php

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function \Pest\Laravel\actingAs;
use function \Pest\Laravel\postJson;
use function \Pest\Laravel\seed;

uses(RefreshDatabase::class);

beforeEach(fn () => seed(UserSeeder::class));

test('initiate chat participant with empty request', function () {
    $testingUser = User::where('email', 'test@example.com')->first();
    actingAs($testingUser);

    $response = postJson('/api/chats');

    $response->assertStatus(422);
});

test('initiate chat participant with less than two participant', function () {
    $testingUser = User::where('email', 'test@example.com')->first();
    $testingParticipantUser = User::where('email', '!=', 'test@example.com')->first();
    actingAs($testingUser);

    $response = postJson('/api/chats', ['participant' => [$testingParticipantUser->id]]);

    $response->assertStatus(422);
});

test('initiate chat participant without owner participated', function () {
    $testingUser = User::where('email', 'test@example.com')->first();
    $testingParticipantUsers = User::where('email', '!=', 'test@example.com')->limit(2)->get();
    actingAs($testingUser);

    $response = postJson('/api/chats', ['participant' => $testingParticipantUsers->pluck('id')->toArray()]);

    $response->assertStatus(400);
});

test('correct initiate chat participant action', function () {
    $testingUser = User::where('email', 'test@example.com')->first();
    $testingParticipantUser = User::where('email', '!=', 'test@example.com')->first();
    actingAs($testingUser);

    $response = postJson('/api/chats', ['participant' => [$testingUser->id, $testingParticipantUser->id]]);

    $response->assertStatus(200);
});
