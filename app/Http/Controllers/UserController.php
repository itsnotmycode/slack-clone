<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function update(Request $request)
    {
         User::findOrFail($request->id);

         User::where(['id' => $request->id])->update([
             'name' => $request->name,
             'email' => $request->email,
             'avatar' => $request->file ? $request->file('avatar')->store('avatars', 'public') : '',
         ]);
    }

    public function getUser(Request $request)
    {
        $user = User::where('id', $request->input('id'))->get();
        return $user;
    }
}
