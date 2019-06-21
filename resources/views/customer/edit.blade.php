@extends('master')
@section('title', 'Sửa phòng')

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
            <h1 class="h3 mb-0 text-gray-800">Sửa thông tin khách "{{$customer_detail['customer_name']}}"</h1>
        </div>
        @if(Session::has('existed'))
            <div class="alert alert-danger" role="alert">
                {{Session::get('existed')}}
            </div>
        @endif
        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{Session::get('success')}}
            </div>
        @endif
        @if(Session::has('errors-cus'))
            <div class="alert alert-warning" role="alert">
                {{Session::get('errors-cus')}}
            </div>
        @endif
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{route('customer.update', $customer_detail['id'])}}" id="form-create-room" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="customer_name">Tên<span class="text-danger"> *</span>:</label>
                        <input type="text"
                               class="form-control text-capitalize @error('customer_name') is-invalid @enderror"
                               id="customer_name" name="customer_name"
                               value="{{old('customer_name')?:(isset($customer_detail['customer_name'])?$customer_detail['customer_name']:'')}}"
                               placeholder="">
                        @error('customer_name')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="customer_hometown">Quê quán:</label>
                        <input type="text" class="form-control" id="customer_hometown" name="customer_hometown"
                               placeholder=""
                               value="{{old('customer_hometown')?:(isset($customer_detail['customer_hometown'])?$customer_detail['customer_hometown']:'')}}">
                    </div>
                    <div class="form-group">
                        <label for="customer_phone_number">SĐT:</label>
                        <input type="text"
                               class="form-control @error('customer_phone_number') is-invalid @enderror"
                               id="customer_phone_number" name="customer_phone_number"
                               value="{{old('customer_phone_number')?:(isset($customer_detail['customer_phone_number'])?$customer_detail['customer_phone_number']:'')}}"
                               placeholder="">
                        @error('customer_phone_number')
                        <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="customer_sub_infos">Thông tin thêm:</label>
                        <textarea class="form-control" id="customer_sub_infos" name="customer_sub_infos"
                                  rows="3">{{old('customer_sub_infos')?:(isset($customer_detail['customer_sub_infos'])?$customer_detail['customer_sub_infos']:'')}}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-create-room">Sửa</button>
                </form>
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

