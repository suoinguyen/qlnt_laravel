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
                            <input type="hidden" id="customer_id" name="customer_id"
                                   value="{{$contract_detail['customers']['id']}}">
                            <div class="form-group">
                                <label for="customer_name">Tên:</label>
                                <input type="text" readonly="readonly" class="form-control text-capitalize"
                                       value="{{$contract_detail['customers']['customer_name']}}">
                            </div>
                            <div class="form-group">
                                <label for="customer_phone_number">SĐT:</label>
                                <input type="text" readonly="readonly"
                                       class="form-control"
                                       value="{{$contract_detail['customers']['customer_phone_number']}}">
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
                                <label for="bill_room_price">Giá thuê phòng:</label>
                                <input type="text" class="form-control"
                                       id="bill_room_price" name="bill_room_price"
                                       value="{{old('bill_room_price')}}">
                            </div>
                            <div class="form-group">
                                <label for="bill_date_calc_last">Ngày thanh toán kì trước:</label>
                                <input type="text" class="form-control datepicker"
                                       id="bill_date_calc_last" name="bill_date_calc_last"
                                       value="{{old('bill_date_calc_last')}}">
                            </div>
                            <div class="form-group">
                                <label for="bill_date_calc_new">Ngày thanh toán mới:</label>
                                <input type="text" class="form-control datepicker"
                                       id="bill_date_calc_new" name="bill_date_calc_new"
                                       value="{{old('bill_date_calc_new')}}">
                            </div>
                            <div class="form-group">
                                <label for="bill_electric_number_last">Số điện kì trước:</label>
                                <input type="text" class="form-control"
                                       id="bill_electric_number_last" name="bill_electric_number_last"
                                       value="{{old('bill_electric_number_last')}}">
                            </div>
                            <div class="form-group">
                                <label for="bill_electric_number_new">Số điện mới:</label>
                                <input type="text" class="form-control"
                                       id="bill_electric_number_new" name="bill_electric_number_new"
                                       value="{{old('bill_electric_number_new')}}">
                            </div>
                            <div class="form-group">
                                <label for="bill_water_number_last">Số nước kì trước:</label>
                                <input type="text" class="form-control"
                                       id="bill_water_number_last" name="bill_water_number_last"
                                       value="{{old('bill_water_number_last')}}">
                            </div>
                            <div class="form-group">
                                <label for="bill_water_number_new">Số nước mới:</label>
                                <input type="text" class="form-control"
                                       id="bill_water_number_new" name="bill_water_number_new"
                                       value="{{old('bill_water_number_new')}}">
                            </div>
                            <div class="form-group">
                                <label for="contract_date_calc_money font-weight-bold">Chi phí khác:</label>
                                <div class="form-group form-group-addition">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" name="addition-name-0" class="form-control addition-name" placeholder="Tên chi phí">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" name="addition-value-0" class="form-control addition-value" placeholder="Số tiền">
                                        </div>
                                        <div class="col-md-4">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-addition">+</button>
                                            </div>
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

            var increment_num = $('.form-group-addition').length?$('.form-group-addition').length:0;
            $('body').on('click', '.btn-addition', function () {
                var form_group_parent = $(this).parents('.form-group-addition');
                var clone_html = form_group_parent.clone();
                var increment_num_plus = increment_num++;
                clone_html.find('.addition-name').val('').attr('name', 'addition-name-'+increment_num_plus);
                clone_html.find('.addition-value').val('').attr('name', 'addition-value-'+increment_num_plus);
                if (clone_html.find('.btn-remove-addition').length === 0){
                    clone_html.find('.btn-addition').after('<button type="button" class="btn btn-danger btn-remove-addition">-</button>');
                }
                form_group_parent.after(clone_html);
            });

            $('body').on('click', '.btn-remove-addition', function () {
                var form_group_parent = $(this).parents('.form-group-addition');
                form_group_parent.remove();
            });

        });
    </script>
@endsection

