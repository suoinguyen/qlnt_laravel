@extends('master')
@section('title', 'Đặt phòng')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection

@section('content')
    @if(!$room_detail)
        <div class="alert alert-warning" role="alert">
            Có lỗi xẩy ra. Không tìm thấy phòng trong hệ thống.
        </div>
    @else
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Đặt phòng {{isset($room_detail->name)?$room_detail->name:''}}</h1>
        </div>
        @if(Session::has('errors-cus'))
            <div class="alert alert-warning" role="alert">
                {{Session::get('errors-cus')}}
            </div>
        @endif
        <form action="{{route('room.saveBookRoom', $room_detail->id)}}" method="POST">
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
                                <label for="customer-name">Tên<span class="text-danger"> *</span>:</label>
                                <input type="text" class="form-control @error('customer-name') is-invalid @enderror"
                                       id="customer-name" name="customer-name"
                                       value="{{old('customer-name')}}"
                                       placeholder="">
                                @error('customer-name')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customer-hometown">Quê quán:</label>
                                <input type="text" class="form-control" id="customer-hometown" name="customer-hometown"
                                       placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="customer-phone">SĐT:</label>
                                <input type="text" class="form-control @error('customer-phone') is-invalid @enderror"
                                       id="customer-phone" name="customer-phone"
                                       value="{{old('customer-phone')}}"
                                       placeholder="">
                                @error('customer-phone')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="customer-infos">Thông tin thêm:</label>
                                <textarea class="form-control" id="customer-infos" name="customer-infos"
                                          rows="3"></textarea>
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
                                <label for="electric-number">Số điện<span class="text-danger"> *</span>:</label>
                                <input type="text" class="form-control @error('electric-number') is-invalid @enderror"
                                       id="electric-number" name="electric-number"
                                       value="{{old('electric-number')}}"
                                       placeholder="">
                                @error('electric-number')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="water-number">Số nước<span class="text-danger"> *</span>:</label>
                                <input type="text" class="form-control @error('water-number') is-invalid @enderror"
                                       id="water-number" name="water-number"
                                       value="{{old('water-number')}}"
                                       placeholder="">
                                @error('water-number')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="people-count">Số người:</label>
                                <input type="text" class="form-control @error('people-count') is-invalid @enderror"
                                       id="people-count" name="people-count"
                                       value="{{old('people-count')}}"
                                       placeholder="">
                                @error('people-count')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="deposit-money">Tiền cọc<span class="text-danger"> *</span>:</label>
                                <input type="text" class="form-control @error('deposit-money') is-invalid @enderror"
                                       id="deposit-money" name="deposit-money"
                                       value="{{old('deposit-money')}}"
                                       placeholder="">
                                @error('deposit-money')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="date-rented">Ngày thuê<span class="text-danger"> *</span>:</label>
                                <input type="text" class="form-control @error('date-rented') is-invalid @enderror datepicker"
                                       id="date-rented" name="date-rented"
                                       value="{{old('date-rented')}}"
                                       placeholder="">
                                @error('date-rented')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="date-calc-money">Ngày chốt sổ<span class="text-danger"> *</span>:</label>
                                <select class="form-control @error('date-calc-money') is-invalid @enderror"
                                        id="date-calc-money" name="date-calc-money">
                                    <option value="">Chọn ngày...</option>
                                    <option value="10" {{old('date-calc-money') == '10' ? 'selected' : ''}}>Ngày 10 hàng tháng</option>
                                    <option value="20" {{old('date-calc-money') == '20' ? 'selected' : ''}}>Ngày 20 hàng tháng</option>
                                </select>
                                @error('date-calc-money')
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.vi.min.js"></script>
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

