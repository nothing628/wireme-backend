<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SendMessageRequest;

class MessageController extends Controller
{
    public function listUserMessage($chat_id, Request $request)
    {
        $currentUser = $request->user();
        $currentChat = $currentUser->chats()->where('id', $chat_id)->first();

        if ($currentChat) {
            $messages = $currentChat->messages()->orderBy('created_at', 'desc')->limit(10)->get();

            return response()->json([
                'messages' => $messages
            ]);
        }

        abort(404, 'Chat not found');
    }

    public function sendMessage($chat_id, SendMessageRequest $request)
    {
        $currentUser = $request->user();
        $currentChat = $currentUser->chats()->where('id', $chat_id)->first();

        if ($currentChat) {
            $message = $request->all();

            return response()->json([
                'success' => true
            ]);
        }

        abort(400, 'Chat not found');
    }
}
