<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create random chat
        \App\Models\Chat::factory(10)->create();
        $testUser = \App\Models\User::where('email', 'test@example.com')->get();

        if ($testUser->count() > 0) {
            $this->createChatWithTestUser();
        }
    }

    private function createChatWithTestUser()
    {
        $testUser = \App\Models\User::where('email', 'test@example.com')->get();
        $testAnotherUser = \App\Models\User::where('email', '!=', 'test@example')->limit(1)->get();

        \App\Models\Chat::factory()
            ->hasAttached($testUser, [], 'participants')
            ->hasAttached($testAnotherUser, [], 'participants')
            ->create();
    }
}
