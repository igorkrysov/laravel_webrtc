<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SettingRoom;

class ChatController extends Controller
{
    public function login(){
      $users = SettingRoom::where('room_id', 1)->get()->pluck('nick', 'pass');

      //dump($users);
      return view('login',['users' => $users]);
    }

    public function chat(Request $request){
      $this->validate($request, [
        'nick' => 'required',
        'pass' => 'required',
        'fio' => 'required',
        ]);

      if(SettingRoom::where('nick', $request->input('nick'))->where('pass', $request->input('pass'))->where('room_id', 1)->count() != 1)
      {
        return redirect()->back();
      }

      // $users = ['igor', 'serzh'];
      $users = SettingRoom::where('room_id', 1)->get()->pluck('nick');


      return view('chat_recreate', ['nick' => $request->input('nick'), 'users' => $users, 'fio' => $request->input('fio'), 'microphoneonly' => $request->input('camera')]);
    }

    public function test(){
      return view('test');
    }
}
