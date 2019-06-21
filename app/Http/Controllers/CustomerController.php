<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get list Room
        $list_customer = Customer::with('contracts.rooms')->get()->toArray();
        return view('customer.index', compact('list_customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer, $id)
    {
        $customer_detail = Customer::with('contracts.rooms')->find($id);
        if ($customer_detail) {
            $customer_detail = $customer_detail->toArray();
        }
        return view('customer.show', compact('customer_detail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer, $id)
    {
        $customer_detail = Customer::find($id);
        if ($customer_detail) {
            $customer_detail = $customer_detail->toArray();
        }
        return view('customer.edit', compact('customer_detail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer, $id)
    {
        $response = Customer::find($id);
        if (!$response){
            //Existed
            return redirect(route('customer.edit'))->withInput()->with(['existed' => 'Khách này không tồn tại trong hệ thống.']);
        }

        $all_data = $request->all();

        //Validate
        $messages = [
            'customer_name.required' => 'Vui lòng nhập tên người thuê.',
            'customer_phone_number.numeric' => 'SĐT không đúng chuẩn.',
        ];
        $rules = [
            'customer_name' => 'required',
            'customer_phone_number' => 'nullable|numeric',
        ];

        Validator::make($all_data, $rules, $messages)->validate();

        //Pass validate
        //Update
        $response->customer_name = $all_data['customer_name']?:'';
        $response->customer_hometown = $all_data['customer_hometown']?:'';
        $response->customer_phone_number = $all_data['customer_phone_number']?:'';
        $response->customer_sub_infos = $all_data['customer_sub_infos']?:'';
        $result = $response->save();

        if ($result){
            return redirect(route('customer.edit', $response->id))->with(['success' => 'Sửa thông tin khách thành công.']);
        }
        return redirect(route('customer.edit', $response->id))->withInput()->with(['errors-cus' => 'Đã có lỗi xẩy ra.']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
