<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Helpers;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('setting');
    }

    public function saveSetting(Request $request){
        $all_data = $request->all();

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
        ];
        $rules = [
            'electric_price' => 'required|numeric',
            'water_price' => 'required|numeric',
            'trash_price' => 'required|numeric',
            'room_price_1' => 'required|numeric',
            'room_price_2' => 'required|numeric',
            'room_price_3' => 'required|numeric',
        ];

        Validator::make($all_data, $rules, $messages)->validate();

        if (isset($all_data['_token'])){
            unset($all_data['_token']);
        }

        try{
            if (is_array($all_data) && !empty($all_data)){
                foreach ($all_data as $key => $value){
                    $result = Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value]
                    );
                }
            }
        }catch (\Exception $exception){
            return redirect(route('app.config'))->withInput()->with(['errors-cus' => 'Đã có lỗi xẩy ra, vui lòng thử lại.']);
        }
        return redirect(route('app.config'))->withInput()->with(['success' => 'Lưu cài đặt thành công.']);
    }
}
