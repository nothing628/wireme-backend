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

    public function sendMessage(SendMessageRequest $request)
    {
        $message = $request->all();

        dd($message);

        return response()->json([
            'success' => true
        ]);
    }
}
