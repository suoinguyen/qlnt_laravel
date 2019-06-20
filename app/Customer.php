<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    public function contracts()
    {
        return $this->hasOne('App\Contract', 'id_customer', 'id');
    }

    public static function createCustomer($params){
        $khach_m = new Customer();
        $khach_m->customer_name = $params['customer_name']?:'';
        $khach_m->customer_hometown = $params['customer_hometown']?:'';
        $khach_m->customer_phone_number = $params['customer_phone_number']?:'';
        $khach_m->customer_sub_infos = $params['customer_sub_infos']?:'';

        $result = $khach_m->save();

        if (!$result){
            return false;
        }

        return $khach_m;
    }
}
