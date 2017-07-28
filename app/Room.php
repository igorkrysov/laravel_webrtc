<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function setting()
    {
        return $this->hasMany('App\SettingRoom', 'room_id', 'id');
    }
}
