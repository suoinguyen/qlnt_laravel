<?php

namespace App\Http\Controllers;

use App\Contract;
use App\Room;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $list_room = Room::all()->toArray();
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
            $contract_detail = $room_detail->contracts()->where('status', '=', '1')->with('customers')->first();
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
        if ($room_detail){
            $room_detail = $room_detail->toArray();
        }
        return view('room.book-room', compact('room_detail'));
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
        $params = array(
            'id_room' => $id,
            'id_customer' => $customer_id,
            'contract_electric_number' => $all_data['contract_electric_number']?:'',
            'contract_water_number' => $all_data['contract_water_number']?:'',
            'contract_people_count' => $all_data['contract_people_count']?:'',
            'contract_deposits_money' => $all_data['contract_deposits_money']?:'',
            'contract_date_rented' => $all_data['contract_date_rented']?:'',
            'contract_date_calc_money' => $all_data['contract_date_calc_money']?:'',
        );
        $create_contract_result = Contract::createContract($params);

        if (!$create_contract_result){
            //Delete customer if create contract fail
            $delete_customer_result = $create_customer_result->delete();

            return back()->withInput()->with(['errors-cus' => 'Có lỗi xẩy ra. Không đặt được phòng.']);
        }
        //Update Room status
        $room_detail->status = '1';
        $update_room_result = $room_detail->save();
        if (!$update_room_result){
            $delete_customer_result = $create_customer_result->delete();
            $delete_contract_result = $create_contract_result->delete();
            return back()->withInput()->with(['errors-cus' => 'Có lỗi xẩy ra. Không đặt được phòng.']);
        }
        return redirect(route('dashboard'))->with(['success' => 'Đặt phòng "'.$room_detail['room_name'].'" thành công.']);
    }

    public function cancelRoom(Request $request, $id){
        dd(1111);
    }

    public function payBill(Request $request, $id){
        $room_detail = Room::find($id);
        $contract_detail = array();
        if ($room_detail) {
            $contract_detail = $room_detail->contracts()->where('status', '=', '1')->with('customers')->first();
            if ($contract_detail){
                $contract_detail = $contract_detail->toArray();
            }
            $room_detail = $room_detail->toArray();
        }
        return view('room.pay-bill', compact('room_detail', 'contract_detail'));
    }

    public function doPayBill(Request $request, $id){
        dd(3333);
    }
}
