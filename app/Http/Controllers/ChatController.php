<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Requests\InitiateChatRequest;

class ChatController extends Controller
{
    public function listUserChat()
    {
        return response()->json([
            'chats' => []
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

        return response()->json([]);
    }

    protected function hasOwnerInParticipantCollection(Collection $participantCollection, $ownerId)
    {
        $hasOwner = $participantCollection->contains(function ($value) use ($ownerId) {
            return $value == $ownerId;
        });

        return $hasOwner;
    }
}
