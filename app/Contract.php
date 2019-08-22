<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contracts';

    public function rooms()
    {
        return $this->belongsTo('App\Room', 'id_room', 'id');
    }
    public function customers()
    {
        return $this->belongsTo('App\Customer', 'id_customer', 'id');
    }

    public static function createContract($params){
        $contract_m = new Contract();
        $contract_m->id_room = $params['id_room']?:0;
        $contract_m->id_customer = $params['id_customer']?:0;
        $contract_m->contract_electric_number = $params['contract_electric_number']?:0;
        $contract_m->contract_water_number = $params['contract_water_number']?:0;
        $contract_m->contract_people_count = $params['contract_people_count']?:1;
        $contract_m->contract_deposits_money = $params['contract_deposits_money']?:0;
        $contract_m->contract_date_rented = $params['contract_date_rented']?:'';
        $contract_m->contract_date_calc_money = $params['contract_date_calc_money']?:'';
        $contract_m->contract_status = true;
        $result = $contract_m->save();

        return $result?:false;
    }
}
