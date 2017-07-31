<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\SettingRoom;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();

        return view('rooms', ['rooms' => $rooms]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $room = new Room();
         $room->name = $request->input('room');
         $room->save();

         return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $room = Room::find($id);
      $room->delete();

      return redirect()->back();
    }

    public function setting_room($id)
    {
      $room = Room::find($id);

      return view('room', ['room' => $room]);
    }

    public function setting_generate(Request $request)
    {
        $this->validate($request, [
          'count_users' => 'required|integer|min:2|max:5'
          ]);

        $id = $request->input('id');
        $room = Room::find($id);
        $room->setting()->delete();

        for($i = 1; $i <= $request->input("count_users"); $i++){
            $setting = new SettingRoom();
            $setting->nick = "user".$i;
            $setting->room_id = $id;
            $setting->pass = str_random(8);

            $room->setting()->save($setting);
        }

        return redirect()->back();
    }
}
