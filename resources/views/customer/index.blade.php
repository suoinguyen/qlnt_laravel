@extends('master')
@section('title', 'Danh sách khách thuê')

@section('css')
    <!-- Custom styles for this page -->
    <link href="{{asset('sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách khách thuê</h1>
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
                        <th>Tên Khách</th>
                        <th>Phòng Thuê</th>
                        <th>SĐT</th>
                        <th>Quê Quán</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Tên Khách</th>
                        <th>Phòng Thuê</th>
                        <th>SĐT</th>
                        <th>Quê Quán</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @if(isset($list_customer) && is_array($list_customer) && !empty($list_customer))
                        @foreach($list_customer as $customer)
                            @php
                                $room_name = isset($customer['contracts']['rooms']['room_name'])?$customer['contracts']['rooms']['room_name']:'';
                                $room_id = isset($customer['contracts']['rooms']['id'])?$customer['contracts']['rooms']['id']:'';
                            @endphp
                            <tr>
                                <td><a href="{{route('customer.show', $customer['id'])}}">{{$customer['customer_name']}}</a></td>
                                <td><a href="{{route('room.show', $room_id)}}">Phòng {{$room_name}}</a></td>
                                <td>{{$customer['customer_phone_number']}}</td>
                                <td>{{$customer['customer_hometown']}}</td>
                                <td>
                                    <a href="{{route('customer.edit', $customer['id'])}}" class="btn btn-sm btn-primary btn-edit">Sửa</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Delete Modal-->
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
                    'targets': [3],
                    'orderable': false,
                }]
            });

            //Delete
            $('.btn-delete').on('click', function () {
                var room_id = $(this).data('id');
                var room_name = $(this).data('name');
                $('.room-name-delete').text(room_name);
                $('#deleteModal').modal('show');
                var href = '/phong/xoa-phong/'+room_id;
                $('.btn-modal-delete').attr('href', href);
            })
        });
    </script>
@endsection

