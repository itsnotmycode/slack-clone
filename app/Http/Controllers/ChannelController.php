<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Channel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Channel::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Channel::create();
    }
}
