<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Models\Chat;
use App\Http\Requests\InitiateChatRequest;

class ChatController extends Controller
{
    public function listUserChat(Request $request)
    {
        $currentUser = $request->user();
        $chats = $currentUser->chats;

        return response()->json([
            'chats' => $chats
        ]);
    }

    public function initiateChat(InitiateChatRequest $request)
    {
        $chatOwner = $request->user();
        $participants = $request->input('participant');
        $participantCollection = collect($participants);
        $hasOwner = $this->hasOwnerInParticipantCollection($participantCollection, $chatOwner->id);

        if (!$hasOwner) {
            return response()->json(['error' => "Should have owner in participant list"], 400);
        }

        $newChat = $this->createChatModel($participantCollection);

        return response()->json([
            'chat' => $newChat
        ]);
    }

    protected function createChatModel(Collection $participantCollection)
    {
        $newChat = new Chat;
        $newChat->last_message = '';
        $newChat->last_seen_at = now();
        $newChat->save();

        $newChat->participants()->attach($participantCollection);

        return $newChat;
    }

    protected function hasOwnerInParticipantCollection(Collection $participantCollection, $ownerId)
    {
        $hasOwner = $participantCollection->contains(function ($value) use ($ownerId) {
            return $value == $ownerId;
        });

        return $hasOwner;
    }
}
