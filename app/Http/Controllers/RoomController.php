<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Contract;
use App\Helpers\Helpers;
use App\Room;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get list Room
        $list_room = Room::with([
            'contracts' => function($query){
                $query->where('contract_status', '=', '1');
            }
        ])->get()->toArray();
        return view('room.index', compact('list_room'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('room.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate
        $messages = [
            'room_name.required' => 'Vui lòng nhập tên phòng.',
            'room_name.unique' => 'Phòng này đã tồn tại.',
            'room_floor.required' => 'Vui lòng chọn tầng.',
            'room_floor.integer' => 'Vui lòng chọn tầng.',
            'room_floor.min' => 'Vui lòng chọn tầng.',
        ];
        $rules = [
            'room_name' => 'required|unique:rooms,room_name',
            'room_floor' => 'required|integer|min:1',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        //Pass validate
        $room_name = $request->input('room_name');
        $room_floor = $request->input('room_floor');

        $result = Room::where('room_name', $room_name)->first();
        if ($result){
            //Existed
            return redirect(route('room.create'))->withInput()->with(['existed' => 'Phòng này đã tồn tại, xin vui lòng nhập tên khác.']);
        }

        //Save
        $params = array(
            'room_name' => $room_name,
            'room_floor' => $room_floor,
        );
        $result = Room::createRoom($params);

        if ($result){
            return redirect(route('room.create'))->with(['success' => 'Tạo phòng thành công.']);
        }
        return redirect(route('room.create'))->withInput()->with(['errors-cus' => 'Đã có lỗi xẩy ra.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room, $id)
    {
        $room_detail = Room::find($id);
        $contract_detail = array();
        if ($room_detail) {
            $contract_detail = $room_detail->contracts()->where('contract_status', '=', '1')->with('customers')->first();
            if ($contract_detail){
                $contract_detail = $contract_detail->toArray();
            }
            $room_detail = $room_detail->toArray();
        }
        return view('room.show', compact('room_detail', 'contract_detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room, $id)
    {
        $room_detail = Room::find($id);
        if ($room_detail) {
            $room_detail = $room_detail->toArray();
        }
        return view('room.edit', compact('room_detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room, $id = 0)
    {
        $response = Room::find($id);
        if (!$response){
            //Existed
            return redirect(route('room.create'))->withInput()->with(['existed' => 'Phòng này không tồn tại.']);
        }

        //Validate
        $messages = [
            'room_name.required' => 'Vui lòng nhập tên phòng.',
            'room_name.unique' => 'Phòng này đã tồn tại.',
            'room_floor.required' => 'Vui lòng chọn tầng.',
            'room_floor.integer' => 'Vui lòng chọn tầng.',
            'room_floor.min' => 'Vui lòng chọn tầng.',
        ];
        $rules = [
            'room_name' => 'required|unique:rooms,room_name,'.$response->id,
            'room_floor' => 'required|integer|min:1',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        //Pass validate
        $room_name = $request->input('room_name');
        $room_floor = $request->input('room_floor');

        //Update
        $response->room_name = $room_name;
        $response->room_floor = $room_floor;

        $result = $response->save();

        if ($result){
            return redirect(route('room.edit', $response->id))->with(['success' => 'Sửa phòng thành công.']);
        }
        return redirect(route('room.edit', $response->id))->withInput()->with(['errors-cus' => 'Đã có lỗi xẩy ra.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room, $id)
    {
        $response = Room::find($id);
        if (!$response){
            return redirect(route('room.list'))->withInput()->with(['errors-cus' => 'Đã có lỗi xẩy ra.']);
        }

        $room_name = $response->room_name;
        $result = $response->delete();
        if ($result){
            return redirect(route('room.list'))->with(['success' => 'Xóa phòng "'.$room_name.'" thành công.']);
        }
    }

    public function bookRoom(Request $request, $id)
    {
        $room_detail = Room::find($id);
        $is_booked = false;
        if ($room_detail){
            $room_detail = $room_detail->toArray();
            $is_booked = Room::checkRoomIsRented($id);
        }
        return view('room.book-room', compact('room_detail', 'is_booked'));
    }

    public function saveBookRoom(Request $request, $id)
    {
        $room_detail = Room::find($id);
        if (!$room_detail){
            return back()->withInput()->with(['errors-cus' => 'Có lỗi xẩy ra. Không tìm thấy phòng trong hệ thống.']);
        }

        $all_data = $request->all();

        //Validate
        $messages = [
            'customer_name.required' => 'Vui lòng nhập tên người thuê.',
            'customer_phone_number.numeric' => 'SĐT không đúng chuẩn.',
            'contract_electric_number.required' => 'Vui lòng nhập số điện.',
            'contract_electric_number.numeric' => 'Phải là số.',
            'contract_water_number.required' => 'Vui lòng nhập số nước.',
            'contract_water_number.numeric' => 'Phải là số.',
            'contract_deposits_money.required' => 'Vui lòng nhập số tiền cọc.',
            'contract_deposits_money.numeric' => 'Phải là số.',
            'contract_date_rented.required' => 'Vui lòng nhập ngày thuê.',
            'contract_date_rented.date_format' => 'Ngày thuê phải có dạng Ngày/Tháng/Năm (30/12/2019)',
            'contract_date_calc_money.required' => 'Vui lòng nhập ngày chốt sổ.',
            'contract_date_calc_money.numeric' => 'Vui lòng chọn đúng ngày.',
        ];
        $rules = [
            'customer_name' => 'required',
            'customer_phone_number' => 'nullable|numeric',
            'contract_electric_number' => 'required|numeric',
            'contract_water_number' => 'required|numeric',
            'contract_deposits_money' => 'required|numeric',
            'contract_date_rented' => 'required|date_format:d/m/Y',
            'contract_date_calc_money' => 'required|numeric',
        ];

        Validator::make($all_data, $rules, $messages)->validate();

        //Create customer
        $create_customer_result = Customer::createCustomer($all_data);

        if (!$create_customer_result || !isset($create_customer_result->id) || empty($create_customer_result->id)){
            return back()->withInput()->with(['errors-cus' => 'Có lỗi xẩy ra. Không tạo được khách hàng.']);
        }
        $customer_id = $create_customer_result->id;

        //Create contract
        $contract_date_rented = Helpers::dateSave($all_data['contract_date_rented']);
        $params = array(
            'id_room' => $id,
            'id_customer' => $customer_id,
            'contract_electric_number' => $all_data['contract_electric_number']?:0,
            'contract_water_number' => $all_data['contract_water_number']?:0,
            'contract_people_count' => $all_data['contract_people_count']?:1,
            'contract_deposits_money' => $all_data['contract_deposits_money']?:0,
            'contract_date_rented' => $contract_date_rented?:'',
            'contract_date_calc_money' => $all_data['contract_date_calc_money']?:'',
        );
        $create_contract_result = Contract::createContract($params);

        if (!$create_contract_result){
            //Delete customer if create contract fail
            $create_customer_result->delete();
            return back()->withInput()->with(['errors-cus' => 'Có lỗi xẩy ra khi tạo hợp đồng. Không đặt được phòng.']);
        }
        return redirect(route('dashboard'))->with(['success' => 'Đặt phòng "'.$room_detail['room_name'].'" thành công.']);
    }

    public function checkoutRoom(Request $request, $id){
        $room_detail = Room::find($id);
        if (!$room_detail){
            return back()->withInput()->with(['errors-cus' => 'Có lỗi xẩy ra. Không tìm thấy phòng trong hệ thống.']);
        }
        $contracts = Contract::where('id_room', $id)->get();
        $check = true;
        if ($contracts->count()){
            foreach ($contracts as $contract){
                $contract->contract_status = 0;
                $res = $contract->save();
                if (!$res){
                    $check = false;
                }
            }
        }
        if (!$check){
            return back()->withInput()->with(['errors-cus' => 'Thực hiện việc trả phòng thất bại!']);
        }
        return back()->withInput()->with(['success' => 'Thực hiện việc trả phòng thành công!']);
    }

    public function calcMoney(Request $request, $id){
        $room_detail = Room::find($id);
        $contract_detail = array();
        $bill_detail = array();
        if ($room_detail) {
            $contract_detail = $room_detail->contracts()->where('contract_status', '=', '1')->with('customers')->first();
            if ($contract_detail){
                $contract_detail = $contract_detail->toArray();
            }

            //Find newest bill
            $bill_detail = $room_detail->bills()->first();
            if ($bill_detail){
                $bill_detail = $bill_detail->toArray();
            }

            $room_detail = $room_detail->toArray();
        }
        return view('room.calc-money', compact('room_detail', 'contract_detail', 'bill_detail'));
    }

    public function doCalcMoney(Request $request, $id){
        $room_detail = Room::find($id);
        if (!$room_detail){
            return back()->withInput()->with(['errors-cus' => 'Có lỗi xẩy ra. Không tìm thấy phòng trong hệ thống.']);
        }

        $all_data = $request->all();

        //Validate
        $messages = [
            'bill_room_price.required' => 'Vui lòng nhập giá phòng.',
            'bill_room_price.numeric' => 'Phải là số.',
            'bill_date_calc_last.required' => 'Vui lòng nhập ngày thanh toán kì trước.',
            'bill_date_calc_last.date_format' => 'Ngày phải có dạng: Ngày/Tháng/Năm (30/12/2019)',
            'bill_date_calc_new.required' => 'Vui lòng nhập ngày thanh toán mới.',
            'bill_date_calc_new.date_format' => 'Ngày phải có dạng: Ngày/Tháng/Năm (30/12/2019)',
            'bill_electric_number_last.required' => 'Vui lòng nhập số điện kì trước.',
            'bill_electric_number_last.numeric' => 'Phải là số.',
            'bill_electric_number_new.required' => 'Vui lòng nhập số điện mới.',
            'bill_electric_number_new.numeric' => 'Phải là số.',
            'bill_water_number_last.required' => 'Vui lòng nhập số nước kì trước.',
            'bill_water_number_last.numeric' => 'Phải là số.',
            'bill_water_number_new.required' => 'Vui lòng nhập số nước mới.',
            'bill_water_number_new.numeric' => 'Phải là số.',
        ];
        $rules = [
            'bill_room_price' => 'required|numeric',
            'bill_date_calc_last' => 'required|date_format:d/m/Y',
            'bill_date_calc_new' => 'required|date_format:d/m/Y',
            'bill_electric_number_last' => 'required|numeric',
            'bill_electric_number_new' => 'required|numeric',
            'bill_water_number_last' => 'required|numeric',
            'bill_water_number_new' => 'required|numeric',
        ];

        if (isset($all_data['addition']) && !empty($all_data['addition']) && is_array($all_data['addition'])){
            if (count($all_data['addition']) == 1){
                foreach ($all_data['addition'] as $key_addition => $addition){
                    if ($addition['name'] || $addition['value']){
                        $rules['addition.*.name'] = 'required';
                        $rules['addition.*.value'] = 'required|numeric';

                        $messages['addition.*.name.required'] = 'Phải nhập tên.';
                        $messages['addition.*.value.required'] = 'Phải nhập giá trị.';
                        $messages['addition.*.value.numeric'] = 'Phải là số.';
                    }
                }
            }else{
                foreach ($all_data['addition'] as $key_addition => $addition){
                    $rules['addition.*.name'] = 'required';
                    $rules['addition.*.value'] = 'required|numeric';

                    $messages['addition.*.name.required'] = 'Phải nhập tên.';
                    $messages['addition.*.value.required'] = 'Phải nhập giá trị.';
                    $messages['addition.*.value.numeric'] = 'Phải là số.';
                }
            }
        }

        Validator::make($all_data, $rules, $messages)->validate();

        $contract_detail = $room_detail->contracts()->where('contract_status', '=', '1')->with('customers')->first();
        if ($contract_detail){
            $contract_detail = $contract_detail->toArray();
        }

        $addition = isset($all_data['addition']) && is_array($all_data['addition']) && !empty($all_data['addition']) ? json_encode($all_data['addition']): '';

        //Calc money per people
        $calc_money_per_people = 0;
        if ($all_data['people_count'] > 2){
            $calc_money_per_people = ((int) $all_data['people_count'] - 2) * 100;
        }

        //Room Price
        $room_price = (int) $all_data['bill_room_price'];

        //Total day
        $total_day = Helpers::calcTotalDay($all_data['bill_date_calc_last'], $all_data['bill_date_calc_new']);
        if ($total_day === false){
            return back()->withInput()->with(['errors-cus' => 'Có lỗi xẩy ra, không tính được số ngày thuê.']);
        }
        //calc money per day
        $calc_money_per_day = ((int)$total_day * $room_price) / 30;

        //Calc money electric
        $calc_money_electric = (int)$all_data['bill_electric_number_new'] - (int)$all_data['bill_electric_number_last'];
        $calc_money_electric *=

        //Calc money water
        $calc_total = $calc_money_per_people +$calc_money_per_day;
        $params = array(
            'id_room' => $id,
            'id_customer' => $contract_detail['id_customer'],
            'bill_people_count' => $all_data['bill_people_count'],
            'bill_room_price' => $room_price,
            'bill_date_calc_last' => $all_data['bill_date_calc_last'],
            'bill_date_calc_new' => $all_data['bill_date_calc_new'],
            'bill_electric_number_last' => $all_data['bill_electric_number_last'],
            'bill_electric_number_new' => $all_data['bill_electric_number_new'],
            'bill_water_number_last' => $all_data['bill_water_number_last'],
            'bill_water_number_new' => $all_data['bill_water_number_new'],
            'bill_addition' => $addition,
            'bill_status' => $all_data['bill_status'],
            'bill_notes' => $all_data['bill_notes'],
            'bill_debt_money' => $all_data['bill_debt_money'],
        );
        $create_bill_result = Bill::createBill($params);
    }


}
