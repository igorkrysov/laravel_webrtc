<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function login(){
      return view('login');
    }

    public function chat(Request $request){
      if(!$request->has('nick')){
        return redirect()->back();
      }

      $users = ['igor', 'serzh'];
      return view('chat', ['nick' => $request->input('nick'), 'users' => $users]);
    }
}
