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
    @elseif($is_booked)
        <div class="alert alert-warning" role="alert">
            Phòng này đã được thuê rồi.
        </div>
    @else
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Đặt phòng {{$room_detail['room_name']}}</h1>
        </div>
        @if(Session::has('errors-cus'))
            <div class="alert alert-warning" role="alert">
                {{Session::get('errors-cus')}}
            </div>
        @endif
        <form action="{{route('room.saveBookRoom', $room_detail['id'])}}" method="POST">
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
                                <label for="customer_name">Tên<span class="text-danger"> *</span>:</label>
                                <input type="text" class="form-control text-capitalize @error('customer_name') is-invalid @enderror"
                                       id="customer_name" name="customer_name"
                                       value="{{old('customer_name')}}"
                                       placeholder="">
                                @error('customer_name')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customer_hometown">Quê quán:</label>
                                <input type="text" class="form-control text-capitalize" id="customer_hometown" name="customer_hometown"
                                       placeholder="" value="{{old('customer_hometown')}}">
                            </div>
                            <div class="form-group">
                                <label for="customer_phone_number">SĐT:</label>
                                <input type="text"
                                       class="form-control @error('customer_phone_number') is-invalid @enderror"
                                       id="customer_phone_number" name="customer_phone_number"
                                       value="{{old('customer_phone_number')}}"
                                       placeholder="">
                                @error('customer_phone_number')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customer_sub_infos">Thông tin thêm:</label>
                                <textarea class="form-control" id="customer_sub_infos" name="customer_sub_infos"
                                          rows="3">{{old('customer_sub_infos')}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Thông tin đặt phòng:</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="contract_electric_number">Số điện<span class="text-danger"> *</span>:</label>
                                <input type="text" class="form-control @error('contract_electric_number') is-invalid @enderror"
                                       id="contract_electric_number" name="contract_electric_number"
                                       value="{{old('contract_electric_number')}}"
                                       placeholder="">
                                @error('contract_electric_number')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="contract_water_number">Số nước<span class="text-danger"> *</span>:</label>
                                <input type="text" class="form-control @error('contract_water_number') is-invalid @enderror"
                                       id="contract_water_number" name="contract_water_number"
                                       value="{{old('contract_water_number')}}"
                                       placeholder="">
                                @error('contract_water_number')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="contract_people_count">Số người:</label>
                                <input type="text" class="form-control @error('contract_people_count') is-invalid @enderror"
                                       id="contract_people_count" name="contract_people_count"
                                       value="{{old('contract_people_count')}}"
                                       placeholder="">
                                @error('contract_people_count')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="contract_deposits_money">Tiền cọc<span class="text-danger"> *</span>:</label>
                                <input type="text" class="form-control @error('contract_deposits_money') is-invalid @enderror"
                                       id="contract_deposits_money" name="contract_deposits_money"
                                       value="{{old('contract_deposits_money')}}"
                                       placeholder="">
                                @error('contract_deposits_money')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="contract_date_rented">Ngày thuê<span class="text-danger"> *</span>:</label>
                                <input type="text"
                                       class="form-control @error('contract_date_rented') is-invalid @enderror datepicker"
                                       id="contract_date_rented" name="contract_date_rented"
                                       value="{{old('contract_date_rented')}}"
                                       placeholder="">
                                @error('contract_date_rented')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="contract_date_calc_money">Ngày chốt sổ<span class="text-danger"> *</span>:</label>
                                <select class="form-control @error('contract_date_calc_money') is-invalid @enderror"
                                        id="contract_date_calc_money" name="contract_date_calc_money">
                                    <option value="">Chọn ngày...</option>
                                    <option value="10" {{old('contract_date_calc_money') == '10' ? 'selected' : ''}}>Ngày 10 hàng
                                        tháng
                                    </option>
                                    <option value="20" {{old('contract_date_calc_money') == '20' ? 'selected' : ''}}>Ngày 20 hàng
                                        tháng
                                    </option>
                                </select>
                                @error('contract_date_calc_money')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-book-room">Đặt phòng</button>
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
                todayHighlight: true,
                autoclose: true,
                assumeNearbyYear: true,
                language: 'vi'
            });
        });
    </script>
@endsection

