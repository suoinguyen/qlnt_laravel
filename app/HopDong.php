<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HopDong extends Model
{
    protected $table = 'contracts';

    public static function createContract($params){
        $hopdong_m = new HopDong();
        $hopdong_m->id_room = $params['id_room']?:'';
        $hopdong_m->id_customer = $params['id_customer']?:'';
        $hopdong_m->contract_electric_number = $params['contract_electric_number']?:'';
        $hopdong_m->contract_water_number = $params['contract_water_number']?:'';
        $hopdong_m->contract_people_count = $params['contract_people_count']?:'';
        $hopdong_m->contract_deposits_money = $params['contract_deposits_money']?:'';
        $hopdong_m->contract_date_rented = $params['contract_date_rented']?:'';
        $hopdong_m->contract_date_calc_money = $params['contract_date_calc_money']?:'';
        $hopdong_m->status = '1';
    }
}
