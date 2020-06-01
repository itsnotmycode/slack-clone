<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $userInfo = [
            'name' => $user->name,
            'email' => $user->email,
        ];
        return view('dashboard', ['userInfo' => $userInfo]);
    }
}
