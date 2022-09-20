<?php

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
