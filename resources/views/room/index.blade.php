@extends('master')
@section('title', 'Danh sách phòng')

@section('css')
    <!-- Custom styles for this page -->
    <link href="{{asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách phòng</h1>
    </div>
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
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableRooms" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Phòng</th>
                        <th>Trạng thái</th>
                        <th>Tiền chốt</th>
                        <th>Ngày chốt</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Phòng</th>
                        <th>Trạng thái</th>
                        <th>Tiền chốt</th>
                        <th>Ngày chốt</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @if(isset($list_room) && is_array($list_room) && !empty($list_room))
                        @foreach($list_room as $room)
                            @php
                            $contract = isset($room['contracts']) && !empty($room['contracts']) && is_array($room['contracts']) ?$room['contracts'][0]:array();
                            $is_rented = $contract?true:false;
                            $cal_date = isset($contract['contract_date_calc_money']) && !empty($contract['contract_date_calc_money']) ? $contract['contract_date_calc_money']:'';
                            @endphp
                            <tr>
                                <td><a href="{{route('room.show', $room['id'])}}">{{$room['room_name']}}</a></td>
                                @if(empty($is_rented))
                                    <td><i class="fas fa-circle text-success"></i> Còn trống</td>
                                @else
                                    <td><i class="fas fa-circle text-danger"></i> Đã thuê</td>
                                @endif
                                <td></td>
                                <td>{{$cal_date}}</td>
                                <td>
                                    <a href="/phong/sua-phong/{{$room['id']}}" data-id="{{$room['id']}}" class="btn btn-sm btn-primary btn-edit">Sửa</a>
                                    {{--<a href="javascript:void(0)" data-id="{{$room['id']}}" data-name="{{$room['room_name']}}" class="btn btn-sm btn-danger btn-delete">Xóa</a>--}}
                                    @if(empty($is_rented))
                                        <a href="/phong/dat-phong/{{$room['id']}}" data-id="{{$room['id']}}" class="btn btn-sm btn-success btn-rent">Thuê</a>
                                    @else
                                        <a href="/phong/chot-so/{{$room['id']}}" class="btn btn-sm btn-cal-money btn-danger">Chốt sổ</a>
                                        <a href="javascript:void(0)" data-id="{{$room['id']}}" data-name="{{$room['room_name']}}" class="btn btn-sm btn-warning btn-checkout">Trả phòng</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{--<!-- Delete Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa phòng?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Bạn có chắc chắn muốn xóa phòng "<span class="room-name-delete"></span>" này không?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Thôi, Ko xóa</button>
                    <a class="btn btn-primary btn-modal-delete" href="javascript:void(0);">Có, Xóa CMN đi</a>
                </div>
            </div>
        </div>
    </div>--}}

    <!-- Checkout Modal-->
    <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Xác nhận trả phòng?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Bạn có chắc chắn muốn thực hiện việc trả phòng "<span class="room-name-checkout"></span>" này không?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Thôi</button>
                    <a class="btn btn-primary btn-modal-checkout" href="javascript:void(0);">Có</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Page level plugins -->
    <script src="{{asset('sb-admin-2/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script type="text/javascript">
        jQuery('document').ready(function ($) {
            //Datatable
            $('#dataTableRooms').DataTable({
                "pageLength": 25,
                'columnDefs': [{
                    'targets': [-1],
                    'orderable': false,
                }]
            });

            /*//Delete
            $('.btn-delete').on('click', function () {
                var room_id = $(this).data('id');
                var room_name = $(this).data('name');
                $('.room-name-delete').text(room_name);
                $('#deleteModal').modal('show');
                var href = '/phong/xoa-phong/'+room_id;
                $('.btn-modal-delete').attr('href', href);
            })*/

            //Checkout
            $('.btn-checkout').on('click', function () {
                var room_id = $(this).data('id');
                var room_name = $(this).data('name');
                $('.room-name-checkout').text(room_name);
                $('#checkoutModal').modal('show');
                var href = '/phong/tra-phong/'+room_id;
                $('.btn-modal-checkout').attr('href', href);
            })
        });
    </script>
@endsection

