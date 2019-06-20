<?php

namespace App\Http\Controllers;

use App\HopDong;
use App\Phong;
use App\Khach;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get list Phong
        $list_phong = Phong::all();
        return view('phong.index', compact('list_phong'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('phong.create');
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
            'room-name.required' => 'Vui lòng nhập tên phòng.',
            'room-name.unique' => 'Phòng này đã tồn tại.',
            'number-of-floor.required' => 'Vui lòng chọn tầng.',
            'number-of-floor.integer' => 'Vui lòng chọn tầng.',
            'number-of-floor.min' => 'Vui lòng chọn tầng.',
        ];
        $rules = [
            'room-name' => 'required|unique:rooms,name',
            'number-of-floor' => 'required|integer|min:1',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        //Pass validate
        $room_name = $request->input('room-name');
        $room_floor = $request->input('number-of-floor');

        $result = Phong::where('name', $room_name)->first();
        if ($result){
            //Existed
            return redirect(route('room.create'))->withInput()->with(['existed' => 'Phòng này đã tồn tại, xin vui lòng nhập tên khác.']);
        }

        //Save
        $params = array(
            'room_name' => $room_name,
            'room_floor' => $room_floor,
        );
        $result = Phong::createRoom($params);

        if ($result){
            return redirect(route('room.create'))->with(['success' => 'Tạo phòng thành công.']);
        }
        return redirect(route('room.create'))->withInput()->with(['errors-cus' => 'Đã có lỗi xẩy ra.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Phong  $phong
     * @return \Illuminate\Http\Response
     */
    public function show(Phong $phong)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Phong  $phong
     * @return \Illuminate\Http\Response
     */
    public function edit(Phong $phong, $id)
    {
        $phong_detail = Phong::find($id);
        return view('phong.edit', compact('phong_detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Phong  $phong
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Phong $phong, $id = 0)
    {
        $response = Phong::find($id);
        if (!$response){
            //Existed
            return redirect(route('room.create'))->withInput()->with(['existed' => 'Phòng này không tồn tại.']);
        }

        //Validate
        $messages = [
            'room-name.required' => 'Vui lòng nhập tên phòng.',
            'room-name.unique' => 'Phòng này đã tồn tại.',
            'number-of-floor.required' => 'Vui lòng chọn tầng.',
            'number-of-floor.integer' => 'Vui lòng chọn tầng.',
            'number-of-floor.min' => 'Vui lòng chọn tầng.',
        ];
        $rules = [
            'room-name' => 'required|unique:rooms,name,'.$response->id,
            'number-of-floor' => 'required|integer|min:1',
        ];

        Validator::make($request->all(), $rules, $messages)->validate();

        //Pass validate
        $room_name = $request->input('room-name');
        $room_floor = $request->input('number-of-floor');

        //Update
        $response->name = $room_name;
        $response->floor = $room_floor;

        $result = $response->save();

        if ($result){
            return redirect(route('room.edit', $response->id))->with(['success' => 'Sửa phòng thành công.']);
        }
        return redirect(route('room.edit', $response->id))->withInput()->with(['errors-cus' => 'Đã có lỗi xẩy ra.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Phong  $phong
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phong $phong, $id)
    {
        $response = Phong::find($id);
        if (!$response){
            return redirect(route('room.list'))->withInput()->with(['errors-cus' => 'Đã có lỗi xẩy ra.']);
        }

        $room_name = $response->name;
        $result = $response->delete();
        if ($result){
            return redirect(route('room.list'))->with(['success' => 'Xóa phòng "'.$room_name.'" thành công.']);
        }
    }

    public function bookRoom(Request $request, $id)
    {
        $room_detail = Phong::find($id);
        return view('phong.book-room', compact('room_detail'));
    }

    public function saveBookRoom(Request $request, $id)
    {
        $room_detail = Phong::find($id);
        if (!$room_detail){
            return back()->withInput()->with(['errors-cus' => 'Có lỗi xẩy ra. Không tìm thấy phòng trong hệ thống.']);
        }

        $all_data = $request->all();

        //Validate
        $messages = [
            'customer-name.required' => 'Vui lòng nhập tên người thuê.',
            'customer-phone.numeric' => 'SĐT không đúng chuẩn.',
            'electric-number.required' => 'Vui lòng nhập số điện.',
            'electric-number.numeric' => 'Phải là số.',
            'water-number.required' => 'Vui lòng nhập số nước.',
            'water-number.numeric' => 'Phải là số.',
            'deposit-money.required' => 'Vui lòng nhập số tiền cọc.',
            'deposit-money.numeric' => 'Phải là số.',
            'date-rented.required' => 'Vui lòng nhập ngày thuê.',
            'date-rented.date_format' => 'Ngày thuê phải có dạng Ngày/Tháng/Năm (30/12/2019)',
            'date-calc-money.required' => 'Vui lòng nhập ngày chốt sổ.',
            'date-calc-money.numeric' => 'Vui lòng chọn đúng ngày.',
        ];
        $rules = [
            'customer-name' => 'required',
            'customer-phone' => 'nullable|numeric',
            'electric-number' => 'required|numeric',
            'water-number' => 'required|numeric',
            'deposit-money' => 'required|numeric',
            'date-rented' => 'required|date_format:d/m/Y',
            'date-calc-money' => 'required|numeric',
        ];

        Validator::make($all_data, $rules, $messages)->validate();

        //Create customer
        $result = Khach::createCustomer($all_data);

        if (!$result || !isset($result->id) || empty($result->id)){
            return back()->withInput()->with(['errors-cus' => 'Có lỗi xẩy ra. Không tạo được khách hàng.']);
        }
        $customer_id = $result->id;

        //Create contract
        $params = array(
            'id_room' => $id,
            'id_customer' => $customer_id,
            'electric_number' => '',
            'water_number' => '',
            'people_count' => '',
            'deposits_money' => '',
            'date_rented' => '',
            'date_calc_money' => '',
        );
        $result = HopDong::createContract($params);

        if (!$result){
            //TODO: delete customer if create contract fail
            return back()->withInput()->with(['errors-cus' => 'Có lỗi xẩy ra. Không đặt được phòng.']);
        }
        return redirect(route('dashboard'))->with(['success' => 'Đặt phòng thành công.']);
    }
}
