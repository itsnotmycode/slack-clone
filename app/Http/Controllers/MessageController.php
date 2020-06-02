<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Message;
use Illuminate\Http\Request;
use App\Events\WebsocketDemoEvent;

class MessageController extends Controller
{
    public function showMessages(Request $request)
    {
        return Message::with('user')->get();
    }

    public function storeMessage(MessageRequest $request)
    {
        $validated = $request->validated();

        $message = auth()->user()->message()->create([
            'message' => $request->message,
            'channel_id' => intval($request->channel_id),
        ]);
        broadcast(new WebsocketDemoEvent( Message::with('user')->find( $message->id ) ));

        return ['status' => 'success'];
    }
}
