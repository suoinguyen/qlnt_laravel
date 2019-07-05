@extends('master')
@section('title', 'Thông tin chi tiết phòng')

@section('css')
@endsection

@section('content')

    @if(!isset($room_detail) || !is_array($room_detail) || empty($room_detail))
        <div class="alert alert-danger" role="alert">
            Phòng này không tồn tại trong hệ thống.
        </div>
    @else
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div class="title-group d-flex justify-content-between align-items-center w-100">
                <h1 class="h3 mb-0 text-gray-800">
                    Thông tin chi tiết phòng "{{isset($room_detail['room_name'])?$room_detail['room_name']:''}}"
                </h1>
                <div class="group-btn">
                    @if($room_detail['status'])
                        <a href="{{route('room.cancelRoom', $room_detail['id'])}}" class="btn btn-info">Trả phòng</a>
                        <a href="{{route('room.calcMoney', $room_detail['id'])}}" class="btn btn-warning">Chốt sổ</a>
                    @else
                        <a href="{{route('room.bookRoom', $room_detail['id'])}}" class="btn btn-info">Thuê phòng</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thông tin phòng</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-4 font-weight-bold">Tên phòng:</label>
                            <div class="col-sm-8">
                                {{isset($room_detail['room_name'])?$room_detail['room_name']:''}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 font-weight-bold">Tầng:</label>
                            <div class="col-sm-8">{{isset($room_detail['room_floor'])?$room_detail['room_floor']:''}}</div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 font-weight-bold">Trạng thái:</label>
                            <div class="col-sm-8">
                                @if(empty($room_detail['status']))
                                    <i class="fas fa-circle text-success"></i> Còn trống
                                @else
                                    <i class="fas fa-circle text-danger"></i> Đã thuê
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($room_detail['status'])
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Thông tin thuê</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-4 font-weight-bold" for="customer_sub_infos">Khách đang thuê:</label>
                                <div class="col-sm-8">
                                    <a href="{{isset($contract_detail['customers']['id'])?route('customer.show', $contract_detail['customers']['id']):'javascript:void(0)'}}">
                                        {{isset($contract_detail['customers']['customer_name'])?$contract_detail['customers']['customer_name']:''}}
                                    </a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 font-weight-bold" for="customer_sub_infos">Ngày thuê:</label>
                                <div class="col-sm-8">
                                    {{isset($contract_detail['contract_date_rented'])?$contract_detail['contract_date_rented']:'00/00/00'}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 font-weight-bold" for="customer_sub_infos">Ngày chốt sổ:</label>
                                <div class="col-sm-8">
                                    Ngày {{isset($contract_detail['contract_date_calc_money'])?$contract_detail['contract_date_calc_money']:'00'}} hàng tháng.
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 font-weight-bold" for="customer_sub_infos">Hợp đồng #:</label>
                                <div class="col-sm-8">
                                    <a href="{{isset($contract_detail['id'])?route('contract.show', $contract_detail['id']):'javascript:void(0)'}}">#{{isset($contract_detail['id'])?$contract_detail['id']:'000'}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Hóa đơn thanh toán (chỉ khách hiện tại)</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="dataTableRooms" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Tên Khách</th>
                                <th>Ngày Thuê</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Tên Phòng</th>
                                <th>Ngày Thuê</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            <tr>
                                <td><a href="">sadsd</a></td>
                                <td>20/12/2019</td>
                            </tr>
                            <tr>
                                <td><a href="">sadsd</a></td>
                                <td>20/12/2019</td>
                            </tr>
                            <tr>
                                <td><a href="">sadsd</a></td>
                                <td>20/12/2019</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Lịch sử thuê phòng</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="dataTableRooms" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Tên Khách</th>
                                <th>Ngày thuê</th>
                                <th>Ngày trả phòng</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>Tên Khách</th>
                                <th>Ngày thuê</th>
                                <th>Ngày trả phòng</th>
                            </tr>
                            </tfoot>
                            <tbody>
                                <tr>
                                    <td><a href="">sadsd</a></td>
                                    <td>20/12/2019</td>
                                    <td>20/12/2020</td>
                                </tr>
                                <tr>
                                    <td><a href="">sadsd</a></td>
                                    <td>20/12/2019</td>
                                    <td>20/12/2020</td>
                                </tr>
                                <tr>
                                    <td><a href="">sadsd</a></td>
                                    <td>20/12/2019</td>
                                    <td>20/12/2020</td>
                                </tr>
                            </tbody>
                        </table>
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

