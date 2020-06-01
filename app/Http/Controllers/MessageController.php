<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MessageController extends Controller
{
    public function showMessages(Request $request)
    {
        return Message::with('user')->get();
    }

    public function storeMessage(Request $request)
    {
        auth()->user()->message()->create([
            'message' => $request->params['message'],
            'channel_id' => intval($request->params['channel_id']),
        ]);

        return ['status' => 'success'];
    }
}
