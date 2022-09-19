<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SendMessageRequest;

class MessageController extends Controller
{
    public function listUserMessage()
    {
        return response()->json([
            'messages' => []
        ]);
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
