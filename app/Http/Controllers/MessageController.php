<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function listUserMessage()
    {
        return response()->json([
            'messages' => []
        ]);
    }

    public function sendMessage()
    {
        return response()->json([
            'success' => true
        ]);
    }
}
