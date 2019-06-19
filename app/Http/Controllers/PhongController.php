<?php

namespace App\Http\Controllers;

use App\Phong;
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
        $phong_M = new Phong();
        $phong_M->name = $room_name;
        $phong_M->floor = $room_floor;
        $phong_M->status = '0';

        $result = $phong_M->save();

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
        if (!$room_detail){
            return back()->with(['errors-cus' => 'Có lỗi xẩy ra. Không tìm thấy phòng trong hệ thống.']);
        }
        return view('phong.book-room', compact('room_detail'));
    }
}
