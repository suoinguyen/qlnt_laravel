<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';

    public function rooms()
    {
        return $this->belongsTo('App\Room', 'id_room', 'id');
    }
    public function customers()
    {
        return $this->belongsTo('App\Customer', 'id_customer', 'id');
    }

    public static function createBill($params){
        $bill_m = new Bill();
        $bill_m->id_room = $params['customer_name']?:'';
        $bill_m->id_customer = $params['customer_hometown']?:'';
        $bill_m->bill_room_price = $params['customer_phone_number']?:'';
        $bill_m->bill_date_calc_last = $params['customer_sub_infos']?:'';
        $bill_m->bill_date_calc_new = $params['customer_sub_infos']?:'';
        $bill_m->bill_electric_number_last = $params['customer_sub_infos']?:'';
        $bill_m->bill_electric_number_new = $params['customer_sub_infos']?:'';
        $bill_m->bill_water_number_last = $params['customer_sub_infos']?:'';
        $bill_m->bill_water_number_new = $params['customer_sub_infos']?:'';
        $bill_m->bill_addition = $params['customer_sub_infos']?:'';
        $bill_m->bill_status = $params['customer_sub_infos']?:'';
        $bill_m->bill_notes = $params['customer_sub_infos']?:'';
        $bill_m->bill_debt_money = $params['customer_sub_infos']?:'';

        $result = $bill_m->save();

        if (!$result){
            return false;
        }

        return $bill_m;
    }
}
