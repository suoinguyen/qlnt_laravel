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

    public function bills()
    {
        return $this->hasMany('App\Bill', 'id_customer', 'id');
    }

    public static function createCustomer($params){
        $customer_m = new Customer();
        $customer_m->customer_name = $params['customer_name']?:'';
        $customer_m->customer_hometown = $params['customer_hometown']?:'';
        $customer_m->customer_phone_number = $params['customer_phone_number']?:'';
        $customer_m->customer_sub_infos = $params['customer_sub_infos']?:'';

        $result = $customer_m->save();

        if (!$result){
            return false;
        }

        return $customer_m;
    }
}
