<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use App\Events\WebsocketDemoEvent;

class MessageController extends Controller
{
    public function showMessages(Request $request)
    {
        return Message::with('user')->get();
    }

    public function storeMessage(Request $request)
    {
        $message = auth()->user()->message()->create([
            'message' => $request->params['message'],
            'channel_id' => intval($request->params['channel_id']),
        ]);
        broadcast(new WebsocketDemoEvent( Message::with('user')->find( $message->id ) ));

        return ['status' => 'success'];
    }
}
