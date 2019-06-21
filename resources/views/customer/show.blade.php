@extends('master')
@section('title', 'Thông tin chi tiết khách')

@section('css')
@endsection

@section('content')

    @if(!isset($customer_detail) || !is_array($customer_detail) || empty($customer_detail))
        <div class="alert alert-danger" role="alert">
            Khách này không tồn tại trong hệ thống.
        </div>
    @else
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Thông tin chi tiết khách "{{$customer_detail['customer_name']}}"</h1>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Thông tin cá nhân</h6>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 font-weight-bold" for="customer_name">Tên:</label>
                    <div class="col-sm-10">
                        {{isset($customer_detail['customer_name'])?$customer_detail['customer_name']:''}}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 font-weight-bold" for="customer_hometown">Quê quán:</label>
                    <div class="col-sm-10">{{isset($customer_detail['customer_hometown'])?$customer_detail['customer_hometown']:''}}</div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 font-weight-bold" for="customer_phone_number">SĐT:</label>
                    <div class="col-sm-10">{{isset($customer_detail['customer_phone_number'])?$customer_detail['customer_phone_number']:''}}</div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 font-weight-bold" for="customer_sub_infos">Thông tin thêm:</label>
                    <div class="col-sm-10">
                        {!! isset($customer_detail['customer_sub_infos'])?nl2br($customer_detail['customer_sub_infos']):'' !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Thông tin thuê</h6>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 font-weight-bold" for="customer_sub_infos">Phòng đang thuê:</label>
                    <div class="col-sm-10">
                        <a href="{{isset($customer_detail['contracts']['rooms']['id'])?route('room.show', $customer_detail['contracts']['rooms']['id']):'javascript:void(0)'}}">
                            Phòng {{isset($customer_detail['contracts']['rooms']['room_name'])?$customer_detail['contracts']['rooms']['room_name']:''}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section('js')
    <script type="text/javascript">
        jQuery('document').ready(function ($) {

        });
    </script>
@endsection

