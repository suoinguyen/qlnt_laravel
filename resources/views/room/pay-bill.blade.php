@extends('master')
@section('title', 'Đặt phòng')

@section('css')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
    @if(!isset($room_detail) || !is_array($room_detail) || empty($room_detail))
        <div class="alert alert-warning" role="alert">
            Có lỗi xẩy ra. Không tìm thấy phòng trong hệ thống.
        </div>
    @else
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Thanh toán tiền phòng {{$room_detail['room_name']}}</h1>
        </div>
        @if(Session::has('errors-cus'))
            <div class="alert alert-warning" role="alert">
                {{Session::get('errors-cus')}}
            </div>
        @endif
        <form action="{{route('room.doPayBill', $room_detail['id'])}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Thông tin khách hàng:</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="customer_name">Tên:</label>
                                <input type="text" readonly="readonly" class="form-control text-capitalize"
                                       id="customer_name" name="customer_name"
                                       value="{{$contract_detail['customers']['customer_name']}}">
                            </div>
                            <div class="form-group">
                                <label for="customer_phone_number">SĐT:</label>
                                <input type="text" readonly="readonly"
                                       class="form-control"
                                       id="customer_phone_number" name="customer_phone_number"
                                       value="{{$contract_detail['customers']['customer_hometown']}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Thông tin thanh toán:</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="contract_electric_number">Ngày thuê:</label>
                                <input type="text" class="form-control"
                                       id="contract_date_rented" name="contract_date_rented"
                                       value="{{old('contract_date_rented')}}">
                            </div>
                            <div class="form-group">
                                <label for="contract_date_calc_money">Ngày chốt sổ:</label>
                                <input type="text" class="form-control"
                                       id="contract_date_calc_money" name="contract_date_calc_money"
                                       value="{{old('contract_date_calc_money')}}">
                            </div>
                            <div class="form-group">
                                <label for="contract_date_calc_money">Ngày thanh toán:</label>
                                <input type="text" class="form-control"
                                       id="contract_date_calc_money" name="contract_date_calc_money"
                                       value="{{old('contract_date_calc_money')}}">
                            </div>
                            <div class="form-group">
                                <label for="contract_date_calc_money">Số điện cũ:</label>
                                <input type="text" class="form-control"
                                       id="contract_date_calc_money" name="contract_date_calc_money"
                                       value="{{old('contract_date_calc_money')}}">
                            </div>
                            <div class="form-group">
                                <label for="contract_date_calc_money">Số điện mới:</label>
                                <input type="text" class="form-control"
                                       id="contract_date_calc_money" name="contract_date_calc_money"
                                       value="{{old('contract_date_calc_money')}}">
                            </div>
                            <div class="form-group">
                                <label for="contract_date_calc_money">Số nước cũ:</label>
                                <input type="text" class="form-control"
                                       id="contract_date_calc_money" name="contract_date_calc_money"
                                       value="{{old('contract_date_calc_money')}}">
                            </div>
                            <div class="form-group">
                                <label for="contract_date_calc_money">Số nước mới:</label>
                                <input type="text" class="form-control"
                                       id="contract_date_calc_money" name="contract_date_calc_money"
                                       value="{{old('contract_date_calc_money')}}">
                            </div>
                            <div class="form-group">
                                <label for="contract_date_calc_money font-weight-bold">Chi phí khác:</label>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" placeholder="Tên chi phí">
                                        </div>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control" placeholder="Tên chi phí">
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary">+</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-book-room">Thanh toán</button>
                </div>
            </div>
        </form>
    @endif
@endsection

@section('js')
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.vi.min.js"></script>
    <script type="text/javascript">
        jQuery('document').ready(function ($) {
            $('.is-invalid').first().focus();

            $('.datepicker').datepicker({
                format: 'dd/mm/yyyy',
                todayBtn: 'linked',
                todayHighlight: true
            });
        });
    </script>
@endsection

