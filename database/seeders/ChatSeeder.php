<?php

namespace Database\Seeders;

use App\Models\Message;
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
            ->has(
                Message::factory()
                    ->setSenderAndReceiver($testUser->first()->id, $testAnotherUser->first()->id)
                    ->count(3)
            )
            ->has(
                Message::factory()
                    ->setSenderAndReceiver($testAnotherUser->first()->id, $testUser->first()->id)
                    ->count(3)
            )
            ->hasAttached($testUser, [], 'participants')
            ->hasAttached($testAnotherUser, [], 'participants')
            ->create();
    }
}
