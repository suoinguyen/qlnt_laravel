@extends('master')
@section('title', 'Chốt sổ')

@section('css')
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
    @if(!isset($room_detail) || !is_array($room_detail) || empty($room_detail))
        <div class="alert alert-warning" role="alert">
            Có lỗi xẩy ra. Không tìm thấy phòng trong hệ thống.
        </div>
    @elseif(!isset($contract_detail) || !is_array($contract_detail) || empty($contract_detail))
        <div class="alert alert-warning" role="alert">
            Có lỗi xẩy ra. Phòng chưa được thuê.
        </div>
    @else
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tính tiền phòng {{$room_detail['room_name']}}</h1>
        </div>
        @if(Session::has('errors-cus'))
            <div class="alert alert-warning" role="alert">
                {{Session::get('errors-cus')}}
            </div>
        @endif
        <form action="{{route('room.doCalcMoney', $room_detail['id'])}}" method="POST">
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
                <div class="col-md-12">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Thông tin thanh toán:</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="form-group ">
                                <label>Số người ở:</label>
                                <input type="number"
                                       class="form-control"
                                       name="people-count"
                                       value="{{$contract_detail['contract_people_count']}}">
                            </div>
                            <div class="form-group">
                                @php
                                    $room_floor = isset($room_detail['room_floor']) && !empty($room_detail['room_floor']) ? $room_detail['room_floor'] : 0;
                                    $room_floor_field = 'room_price_'.$room_floor;
                                    if (isset($room_detail['room_name']) && $room_detail['room_name'] == '101'){
                                        $room_price = Helpers::getSetting('room_101_price');
                                    }else{
                                        $room_price = Helpers::getSetting($room_floor_field);
                                    }
                                    $room_price = strlen($room_price)>0?$room_price:0;
                                @endphp
                                <label for="bill_room_price">Giá thuê phòng<span class="text-danger">*</span>:</label>
                                <input type="text" class="form-control @error('bill_room_price') is-invalid @enderror"
                                       id="bill_room_price" name="bill_room_price"
                                       value="{{$errors->all()?old('bill_room_price'):$room_price}}">
                                <small class="form-text text-muted">*Đơn vị giá "nghìn đồng".</small>
                                @error('bill_room_price')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                @php
                                    $bill_date_calc_last = isset($bill_detail['bill_date_calc_new']) && !empty($bill_detail['bill_date_calc_new']) ? $bill_detail['bill_date_calc_new'] : $contract_detail['contract_date_rented'];
                                    $bill_date_calc_last = Helpers::dateShow($bill_date_calc_last);
                                @endphp
                                <label for="bill_date_calc_last">Ngày thanh toán kì trước<span
                                        class="text-danger">*</span>:</label>
                                <input type="text"
                                       class="form-control datepicker @error('bill_date_calc_last') is-invalid @enderror"
                                       id="bill_date_calc_last" name="bill_date_calc_last"
                                       value="{{$errors->all()?old('bill_date_calc_last'):$bill_date_calc_last}}">
                                @error('bill_date_calc_last')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="bill_date_calc_new">Ngày thanh toán mới<span
                                        class="text-danger">*</span>:</label>
                                <input type="text"
                                       class="form-control datepicker @error('bill_date_calc_new') is-invalid @enderror"
                                       id="bill_date_calc_new" name="bill_date_calc_new"
                                       value="{{old('bill_date_calc_new')}}">
                                @error('bill_date_calc_new')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                @php
                                    $bill_electric_number_last = isset($bill_detail['bill_electric_number_new']) && strlen($bill_detail['bill_electric_number_new']) ? $bill_detail['bill_electric_number_new'] : ($contract_detail['contract_electric_number']?:0);
                                @endphp
                                <label for="bill_electric_number_last">Số điện kì trước<span
                                        class="text-danger">*</span>:</label>
                                <input type="text"
                                       class="form-control @error('bill_electric_number_last') is-invalid @enderror"
                                       id="bill_electric_number_last" name="bill_electric_number_last"
                                       value="{{$errors->all()?old('bill_electric_number_last'):$bill_electric_number_last}}">
                                @error('bill_electric_number_last')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="bill_electric_number_new">Số điện mới<span
                                        class="text-danger">*</span>:</label>
                                <input type="text"
                                       class="form-control @error('bill_electric_number_new') is-invalid @enderror"
                                       id="bill_electric_number_new" name="bill_electric_number_new"
                                       value="{{old('bill_electric_number_new')}}">
                                @error('bill_electric_number_new')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                @php
                                    $bill_water_number_last = isset($bill_detail['bill_water_number_last']) && strlen($bill_detail['bill_water_number_last']) ? $bill_detail['bill_water_number_last'] : ($contract_detail['contract_water_number']?:0);
                                @endphp
                                <label for="bill_water_number_last">Số nước kì trước<span class="text-danger">*</span>:</label>
                                <input type="text"
                                       class="form-control @error('bill_water_number_last') is-invalid @enderror"
                                       id="bill_water_number_last" name="bill_water_number_last"
                                       value="{{$errors->all()?old('bill_water_number_last'):$bill_water_number_last}}">
                                @error('bill_water_number_last')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="bill_water_number_new">Số nước mới<span
                                        class="text-danger">*</span>:</label>
                                <input type="text"
                                       class="form-control @error('bill_water_number_new') is-invalid @enderror"
                                       id="bill_water_number_new" name="bill_water_number_new"
                                       value="{{old('bill_water_number_new')}}">
                                @error('bill_water_number_new')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="contract_date_calc_money font-weight-bold">Chi phí khác:</label>
                                @if(is_array(old('addition')) && !empty(old('addition')))
                                    @foreach(old('addition') as $key_addition => $addition)
                                        <div class="form-group form-group-addition">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <input type="text" name="addition[{{$key_addition}}][name]"
                                                           class="form-control addition-name @error('addition.'.$key_addition.'.name') is-invalid @enderror"
                                                           placeholder="Tên chi phí"
                                                           value="{{$addition['name']}}">
                                                    @error('addition.'.$key_addition.'.name')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" name="addition[{{$key_addition}}][value]"
                                                           class="form-control addition-value @error('addition.'.$key_addition.'.value') is-invalid @enderror"
                                                           placeholder="Số tiền"
                                                           value="{{$addition['value']}}">
                                                    @error('addition.'.$key_addition.'.value')
                                                    <div class="invalid-feedback">{{$message}}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-primary btn-addition">+
                                                        </button>
                                                        @if($key_addition != 0)
                                                            <button type="button"
                                                                    class="btn btn-danger btn-remove-addition">-
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="form-group form-group-addition">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" name="addition[0][name]"
                                                       class="form-control addition-name" placeholder="Tên chi phí">
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" name="addition[0][value]"
                                                       class="form-control addition-value" placeholder="Số tiền">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary btn-addition">+
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" name="btn-calc-money" class="btn btn-primary btn-calc-money">Tính tiền
                    </button>
                    @if(false)
                        <button type="submit" name="btn-pay-money" class="btn btn-primary btn-pay-money">Thanh toán
                        </button>
                    @endif
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

            var date_picker_default = {
                format: 'dd/mm/yyyy',
                todayBtn: 'linked',
                todayHighlight: true,
                autoclose: true,
                assumeNearbyYear: true,
                language: 'vi'
            };
            $('.datepicker').datepicker(date_picker_default);


            var bill_date_calc_new_val = $('#bill_date_calc_last').val();
            if (bill_date_calc_new_val) {
                reInitDatepicker('#bill_date_calc_new', {
                    startDate: bill_date_calc_new_val
                })
            }

            /**
             *
             * @param element | Class name or Id name
             * @param new_options | object contain datepicker options
             */
            function reInitDatepicker(element, new_options) {
                $(element).datepicker('destroy').datepicker($.extend(
                    {},
                    date_picker_default,
                    new_options
                    )
                );
            }

            $('body').on('click', '.btn-addition', function () {
                var form_group_parent = $(this).parents('.form-group-addition');
                var clone_html = form_group_parent.clone();

                var increment_num = resetNumberOfAddition();

                clone_html.find('.addition-name').val('').attr('name', 'addition[' + increment_num + '][name]');
                clone_html.find('.addition-value').val('').attr('name', 'addition[' + increment_num + '][value]');
                if (clone_html.find('.btn-remove-addition').length === 0) {
                    clone_html.find('.btn-addition').after('<button type="button" class="btn btn-danger btn-remove-addition">-</button>');
                }
                form_group_parent.parent().append(clone_html);
            });

            $('body').on('click', '.btn-remove-addition', function () {
                var form_group_parent = $(this).parents('.form-group-addition');
                form_group_parent.remove();
                resetNumberOfAddition();
            });

            function resetNumberOfAddition() {
                var increment_num = 0;
                $('.form-group-addition').each(function (e) {
                    $(this).find('.addition-name').attr('name', 'addition[' + increment_num + '][name]');
                    $(this).find('.addition-value').attr('name', 'addition[' + increment_num + '][value]');
                    increment_num++;
                });

                return increment_num;
            }

        });
    </script>
@endsection

