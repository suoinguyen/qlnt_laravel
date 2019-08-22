<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';

    public function contracts()
    {
        return $this->hasMany('App\Contract', 'id_room', 'id');
    }

    public function bills()
    {
        return $this->hasMany('App\Bill', 'id_room', 'id');
    }

    public static function createRoom($params){
        $phong_M = new Room();
        $phong_M->room_name = $params['room_name']?:'';
        $phong_M->room_floor = $params['room_floor']?:'';
        /*$phong_M->status = '0';*/

        $result = $phong_M->save();
        if (!$result){
            return false;
        }

        return $phong_M;
    }

    public static function checkRoomIsRented($room_id){
        $contract_detail = Contract::where('id_room', $room_id)->where('contract_status', '1')->first();
        return $contract_detail?true:false;
    }
}
