<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';

    public function rooms()
    {
        return $this->hasOne('App\Room', 'id', 'id_room');
    }

    public static function createContract($params){
        $contract_m = new Contract();
        $contract_m->id_room = $params['id_room']?:'';
        $contract_m->id_customer = $params['id_customer']?:'';
        $contract_m->contract_electric_number = $params['contract_electric_number']?:'';
        $contract_m->contract_water_number = $params['contract_water_number']?:'';
        $contract_m->contract_people_count = $params['contract_people_count']?:'';
        $contract_m->contract_deposits_money = $params['contract_deposits_money']?:'';
        $contract_m->contract_date_rented = $params['contract_date_rented']?:'';
        $contract_m->contract_date_calc_money = $params['contract_date_calc_money']?:'';
        $contract_m->status = '1';
        $result = $contract_m->save();

        return $result?true:false;
    }
}
