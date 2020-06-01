<?php

namespace App\Http\Controllers;

use App\Channel;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Channel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Channel::whereHas('user', function (Builder $query) {
            $query->where('id', auth()->user()->id);
        })
            ->orWhere('user_channel', 0)
            ->where('private', 0)
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $channels = Channel::whereHas('user', function (Builder $query) use ($request) {
            $query->where('id',  $request->params['user_id']);
        })->with('user')
            ->where('user_channel', 1)
            ->get();
        foreach ($channels as $channel) {
            if($channel->user->find(auth()->user()->id)){
                return $channel;
            }
        }

        $newChannel = auth()->user()->channel()->create([
            'name' => $request->params['channel_name'],
            'admin'=> auth()->user()->id,
            'private'=>$request->params['private'],
            'user_channel'=> $request->params['user_channel']
        ]);

        $user = User::find($request->params['user_id']);
        $newChannel->user()->save($user);

        return $newChannel;
    }
}
