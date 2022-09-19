<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $participants = $request->input('participant');

        return response()->json([]);
    }
}
