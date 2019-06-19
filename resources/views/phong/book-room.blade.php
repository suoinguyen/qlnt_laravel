@extends('master')
@section('title', 'Đặt phòng')

@section('css')
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Đặt phòng {{isset($room_detail->name)?$room_detail->name:''}}</h1>
    </div>
    <form action="">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Thông tin khách hàng:</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="customer-name">Tên<span class="text-danger"> *</span>:</label>
                            <input type="text" class="form-control" id="customer-name" name="customer-name"
                                   placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="customer-hometown">Quê quán:</label>
                            <input type="text" class="form-control" id="customer-hometown" name="customer-hometown"
                                   placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="customer-phone">SĐT:</label>
                            <input type="text" class="form-control" id="customer-phone" name="customer-phone"
                                   placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="customer-infos">Thông tin thêm:</label>
                            <textarea class="form-control" id="customer-infos" name="customer-infos" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Thông tin đặt phòng:</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="form-group">
                            <label for="electric-number">Số điện<span class="text-danger"> *</span>:</label>
                            <input type="text" class="form-control" id="electric-number" name="electric-number"
                                   placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="water-number">Số nước<span class="text-danger"> *</span>:</label>
                            <input type="text" class="form-control" id="water-number" name="water-number"
                                   placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="people-number">Số người:</label>
                            <input type="text" class="form-control" id="people-number" name="people-number"
                                   placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="deposit-money">Tiền cọc<span class="text-danger"> *</span>:</label>
                            <input type="text" class="form-control" id="deposit-money" name="deposit-money"
                                   placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="date-rented">Ngày thuê<span class="text-danger"> *</span>:</label>
                            <input type="text" class="form-control" id="date-rented" name="date-rented"
                                   placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="date-calc-money">Ngày chốt sổ<span class="text-danger"> *</span>:</label>
                            <input type="text" class="form-control" id="date-calc-money" name="date-calc-money"
                                   placeholder="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-book-room">Đặt phòng</button>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script type="text/javascript">
        jQuery('document').ready(function ($) {

        });
    </script>
@endsection

