<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SendMessageRequest;
use App\Models\Message;

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
            $content = $request->input('content');
            $message = new Message;
            $message->chat_id = $chat_id;
            $message->sender_id = $currentUser->id;
            $message->content = $content;
            $message->save();

            return response()->json([
                'message' => [
                    'id' => $message->id,
                    'chat_id' => $chat_id,
                    'sender_id' => $currentUser->id,
                    'content' => $content,
                    'created_at' => $message->created_at,
                ]
            ]);
        }

        abort(400, 'Chat not found');
    }
}
