<?php

namespace App\Http\Middleware;

use App\Helpers\Helpers;
use Closure;
use Illuminate\Support\Facades\Validator;

class CheckSetting
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $all_data = [
            'electric_price' => Helpers::getSetting('electric_price')!==false?Helpers::getSetting('electric_price'):'',
            'water_price' => Helpers::getSetting('water_price')!==false?Helpers::getSetting('electric_price'):'',
            'trash_price' => Helpers::getSetting('trash_price')!==false?Helpers::getSetting('electric_price'):'',
            'room_price_1' => Helpers::getSetting('room_price_1')!==false?Helpers::getSetting('electric_price'):'',
            'room_price_2' => Helpers::getSetting('room_price_2')!==false?Helpers::getSetting('electric_price'):'',
            'room_price_3' => Helpers::getSetting('room_price_3')!==false?Helpers::getSetting('electric_price'):'',
            'room_101_price' => Helpers::getSetting('room_101_price')!==false?Helpers::getSetting('electric_price'):'',
        ];

        //Validator
        $messages = [
            'electric_price.required' => 'Vui lòng nhập giá điện.',
            'electric_price.numeric' => 'Phải là số.',
            'water_price.required' => 'Vui lòng nhập giá nước.',
            'water_price.numeric' => 'Phải là số.',
            'trash_price.required' => 'Vui lòng nhập giá rác.',
            'trash_price.numeric' => 'Phải là số.',
            'room_price_1.required' => 'Vui lòng nhập giá tầng 1.',
            'room_price_1.numeric' => 'Phải là số.',
            'room_price_2.required' => 'Vui lòng nhập giá tầng 2.',
            'room_price_2.numeric' => 'Phải là số.',
            'room_price_3.required' => 'Vui lòng nhập giá tầng 3.',
            'room_price_3.numeric' => 'Phải là số.',
            'room_101_price.required' => 'Vui lòng nhập giá phòng 101.',
            'room_101_price.numeric' => 'Phải là số.',
        ];
        $rules = [
            'electric_price' => 'required|numeric',
            'water_price' => 'required|numeric',
            'trash_price' => 'required|numeric',
            'room_price_1' => 'required|numeric',
            'room_price_2' => 'required|numeric',
            'room_price_3' => 'required|numeric',
            'room_101_price' => 'required|numeric',
        ];

        $validator = Validator::make($all_data, $rules, $messages);
        if ($validator->fails()) {
            return redirect(route('app.config'))
                ->withErrors($validator)
                ->withInput()->with(['errors-cus' => 'Xin kiểm tra lại tất cả setting.']);
        }

        return $next($request);
    }
}
