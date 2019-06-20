<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phong extends Model
{
    protected $table = 'rooms';

    public static function createRoom($params){
        $phong_M = new Phong();
        $phong_M->room_name = $params['room_name']?:'';
        $phong_M->room_floor = $params['room_floor']?:'';
        $phong_M->status = '0';

        $result = $phong_M->save();
        if (!$result){
            return false;
        }

        return $phong_M;
    }
}
